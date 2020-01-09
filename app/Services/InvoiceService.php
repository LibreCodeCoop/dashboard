<?php
namespace App\Services;

use App\Company;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function find(User $currentUser = null)
    {
        return DB::table(function (Builder $query) use ($currentUser) {
            $legacy = env('DB_DATABASE_LEGACY');
            $voip = env('DB_DATABASE_VOIP');
            $status = [
                'paid'      => __('__PAID__'),
                'overdue'   => __('__OVERDUE__'),
                'opened'    => __('__OPENED__'),
                'cancelled' => __('__CANCELLED__'),
            ];
            $query
            ->select(["i.id AS invoice_code", "date", "duedate", "total"])
            ->selectRaw('CASE WHEN faturas.invoiceid IS NOT NULL THEN 1 ELSE 0 END AS has_billet')
            ->selectRaw(<<<RAW
                CASE WHEN status = 'Unpaid' AND duedate <= now() THEN '{$status['overdue']}'
                     WHEN status = 'Unpaid' AND duedate > now() THEN '{$status['opened']}'
                     WHEN status = 'Paid' THEN '{$status['paid']}'
                     WHEN status = 'Cancelled' THEN '{$status['cancelled']}'
                     ELSE status END
                  AS status
                RAW
                )
            ->selectRaw("CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END AS client")
            ->addSelect(['c.id AS customer_id'])
            ->from($legacy . '.tblinvoices', 'i')
            ->join(env('DB_DATABASE'). '.customers AS c', 'c.code', '=', 'i.userid')
            ->leftJoin(env('DB_DATABASE').'.companies AS co', function (JoinClause $join){
                $join->on('co.id', '=', 'c.typeable_id')
                    ->where("c.typeable_type", '=', $typeableType = "App\\Company");
            })
            ->leftJoin(env('DB_DATABASE').'.users AS u', function (JoinClause $join){
                $join->on('u.id', '=', 'c.typeable_id')
                    ->where("c.typeable_type", '=', $typeableType = "App\\User");
            })
            ->leftJoin(DB::raw(
                <<<QUERY
                (
                    SELECT invoiceid
                      FROM {$voip}.autourlfaturas
                      JOIN {$legacy}.tblinvoices i ON i.id = autourlfaturas.invoiceid
                     WHERE i.status NOT IN ('Cancelled', 'Paid')
                      GROUP BY invoiceid
                ) faturas
                QUERY
                ), 'faturas.invoiceid', 'i.id')
            ;
            if ($currentUser) {
                $query->leftJoin(env('DB_DATABASE'). '.customer_user AS cu', 'cu.customer_id', '=', 'c.id')
                    ->where('cu.user_id', $currentUser->id);
            }
        })->select(['invoice_code', 'date', 'duedate', 'total', 'status', 'client', 'has_billet', 'customer_id']);
    }

    /**
     * @param $id
     * @return array
     */
    public function products($id): array
    {
        $products = DB::select(DB::raw("
        SELECT DISTINCT
            CONCAT (name, ' (', f.context,')') AS product,
            f.productid,
            f.invoiceid,
            f.context
        FROM voxlink_whmcs_dev.tblproducts AS p
        join voxlink_voip_report_dev.cdr_faturadas AS f on p.id = f.productid
        WHERE f.invoiceid = {$id}
        ORDER BY product ASC;
        "));

        foreach ($products as $product) {
            ;
            $product->details = DB::select(DB::raw("
            SELECT
                datahora,
                origem,
                destino,
                RIGHT(tarifa,
                      LENGTH(tarifa) - INSTR(tarifa, '/')) AS tarifa,
                duracao,
                duracao_faturar,
                duracao_faturado,
                valor_faturado
            FROM
                voxlink_voip_report_dev.cdr_faturadas
            WHERE
                invoiceid = $id AND context = '$product->context'
            ORDER BY datahora DESC
            "));

            $product->total_duration = array_reduce($product->details, function ($carry, $item) {
                return $carry += $item->duracao_faturar;
            });

            $product->total_excedent = array_reduce($product->details, function ($carry, $item) {
                return $carry += $item->duracao_faturado;
            });
        }
        return $products;
    }
}
