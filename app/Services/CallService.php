<?php
namespace App\Services;

use App\Company;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class CallService
{
    public function find()
    {
        return DB::table(function (Builder $query) {
            $query->from((env('DB_DATABASE_LEGACY') . '.tblcustomfieldsvalues as context'))
                ->select(["u.id as us_id", "cs.id as customer_id", "cdr.start_stamp as start_time", "cdr.caller_id_number as origin_number"])
                ->addSelect(["cdr.destination_number", "gravacoes_s3.path_s3"])
                ->selectRaw('CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END as cliente')
                ->selectRaw("CONCAT((cdr.billsec) DIV 60, ':', LPAD((FLOOR(cdr.billsec) MOD 60), 2, 0)) AS 'duration'")
                ->join(env('DB_DATABASE_LEGACY') . ".tblcustomfields as context_field", function (JoinClause $join) {
                    $join->on('context_field.id', '=', 'context.fieldid')
                        ->where("context_field.fieldname", '=', "Dominio no PABX");
                })->join(env('DB_DATABASE_LEGACY') . ".tblhosting as d", 'd.id', '=', 'context.relid')
                ->join(env('DB_DATABASE_LEGACY') . ".tblclients as c", 'c.id', '=', 'd.userid')
                ->join(env('DB_DATABASE_LEGACY') . ".tblcustomfieldsvalues as cfv_doc1", function (JoinClause $join) {
                    $join->on('c.id', '=', 'cfv_doc1.relid')
                        ->where('cfv_doc1.fieldid', '=', $fieldId = '1');
                })->join(env('DB_DATABASE') . ".customers as cs", 'cs.code', '=', 'd.userid')
                ->join(env('DB_DATABASE') . ".customer_user as cu", 'cu.customer_id', '=', 'cs.id')
                ->leftjoin(env('DB_DATABASE') . ".companies as co", function ($join) {
                    $join->on('co.id', '=', 'cs.typeable_id')
                        ->where("cs.typeable_type", '=', $typeableType = "App\Company");
                })->leftjoin(env('DB_DATABASE') . ".users as u", function ($join) {
                    $join->on('u.id', '=', 'cs.typeable_id')
                        ->where('cs.typeable_type', '=', $typeableType = "App\User");
                })->join(env('DB_DATABASE_VOIP') . ".cdr as cdr", function (JoinClause $join) {
                    $join->on('cdr.context', '=', 'context.value')
                        ->orOn(function (JoinClause $j) {
                            $j->whereRaw("cdr.context = SUBSTRING_INDEX(context.value, '/', 1)")
                                ->on(function (JoinClause $o) {
                                    $o->whereraw("cdr.caller_id_number = SUBSTRING_INDEX(context.value, '/', - 1)")
                                        ->orWhereRaw("cdr.destination_number = SUBSTRING_INDEX(context.value, '/', - 1)");
                                });
                        });
                })->leftjoin(env('DB_DATABASE_VOIP') . ".gravacoes_s3", 'cdr.uuid', '=', 'gravacoes_s3.uuid')
                //->where('u.id', '=',  1)
                ->where(function (Builder $query) {
                    $query->where([
                        ['cs.typeable_id', '=', 51],
                        ['cs.typeable_type', '=', 'App\Company'],
                    ]);
                })
//            ->where('cdr.start_stamp',  '=', 1)
//            ->where('cdr.caller_id_number',  '=', 2003)
//            ->where('cdr.destination_number',  '=', 2001)
                ->orderBy('start_time', 'DESC');
        })->select(['us_id', 'customer_id', 'start_time', 'origin_number', 'destination_number', 'path_s3', 'cliente', 'duration']);


        return DB::select(
"SELECT CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END as cliente,
       cdr.start_stamp AS start_time,
       cdr.caller_id_number AS origin_number,
       cdr.destination_number,
       CONCAT((cdr.billsec) DIV 60, ':', LPAD((FLOOR(cdr.billsec) MOD 60), 2, 0)) AS 'Duração',
       gravacoes_s3.path_s3
FROM
    " . env('DB_DATABASE_LEGACY') . ".tblcustomfieldsvalues context
        JOIN ". env('DB_DATABASE_LEGACY'). ".tblcustomfields context_field ON
                context_field.id = context.fieldid
            AND context_field.fieldname = 'Dominio no PABX'
        JOIN ". env('DB_DATABASE_LEGACY') . ".tblhosting d ON
            d.id = context.relid
        JOIN ". env('DB_DATABASE_LEGACY') .".tblclients c ON
            c.id = d.userid
        JOIN ". env('DB_DATABASE_LEGACY') .".tblcustomfieldsvalues cfv_doc1 ON
                c.id = cfv_doc1.relid
            AND cfv_doc1.fieldid = 1
        JOIN ". env('DB_DATABASE') .".customers cs ON cs.code = d.userid
        JOIN ". env('DB_DATABASE') .".customer_user cu ON cu.customer_id = cs.id
        LEFT JOIN ". env('DB_DATABASE') .".companies co ON co.id = cs.typeable_id AND cs.typeable_type = 'App\\Company'
        LEFT JOIN ". env('DB_DATABASE') .".users u ON u.id = cs.typeable_id AND cs.typeable_type = 'App\\User'
        JOIN ". env('DB_DATABASE_VOIP') .".cdr cdr ON
                cdr.context = context.value
            OR (cdr.context = SUBSTRING_INDEX(context.value, '/', 1)
            AND (cdr.caller_id_number = SUBSTRING_INDEX(context.value, '/', - 1)
                OR cdr.destination_number = SUBSTRING_INDEX(context.value, '/', - 1)))
        LEFT JOIN ". env('DB_DATABASE_VOIP') .".gravacoes_s3 ON
            cdr.uuid = gravacoes_s3.uuid
-- WHERE
--        u.id = :id -- Quando não for admin, vem do id da sessão, este é o id do usuário logado
--   AND (cs.typeable_id = :typeable_id AND cs.typeable_type = :typeable_type) -- Filtro pelo customer do usuário logado
  -- AND cdr.start_stamp = :start_samp -- Data inicial
  -- AND cdr.caller_id_number = :caller_id_number -- número de origem
  -- AND cdr.destination_number = :destination_number ? -- Número de destino
ORDER BY
    start_time DESC;
"
,
            [
                'id' => 1,
                'typeable_id' => 1,
                'typeable_type' => 'App\User',
            ]
        );
    }

}
