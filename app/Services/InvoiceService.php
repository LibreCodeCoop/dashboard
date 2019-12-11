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
            $query->from(env('DB_DATABASE_LEGACY'). '.tblinvoices', 'i')
            ->select(["i.id AS invoice_code", "date", "duedate", "total"])
            ->selectRaw("CASE WHEN status = 'Unpaid' AND duedate <= now() THEN 'Em atraso'
                            WHEN status = 'Unpaid' AND duedate > now() THEN 'Em aberto'
                            WHEN status = 'Paid' THEN 'Pago'
                            WHEN status = 'Cancelled' THEN 'Cancelada'
                            ELSE status END
                        AS status")
            ->selectRaw("CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END AS client")
            ->join(env('DB_DATABASE'). '.customers AS c', 'c.code', '=', 'i.userid')
            ->leftJoin(env('DB_DATABASE').'.companies AS co', function (JoinClause $join){
                $join->on('co.id', '=', 'c.typeable_id')
                    ->where("c.typeable_type", '=', $typeableType = "App\\Company");
            })
            ->leftJoin(env('DB_DATABASE').'.users AS u', function (JoinClause $join){
                $join->on('u.id', '=', 'c.typeable_id')
                    ->where("c.typeable_type", '=', $typeableType = "App\\User");
            })
            ->join(env('DB_DATABASE'). '.customer_user AS cu', 'cu.customer_id', '=', 'c.id')
            ;
            if ($currentUser) {
                $query->where('cu.user_id', $currentUser->id);
            }
        })->select(['invoice_code', 'date', 'duedate', 'total', 'status', 'client']);
    }
}
