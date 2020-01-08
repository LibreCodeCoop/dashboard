<?php
namespace App\Services;

use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class CallService
{
    public function find(User $currentUser = null)
    {
        return DB::table(function (Builder $query) use ($currentUser){
            $query
                ->select(["u.id as us_id", "cs.id as customer_id", "cdr.start_stamp as start_time", "cdr.caller_id_number as origin_number"])
                ->addSelect(["cdr.destination_number"]);
            if ($currentUser) {
                $query
                    ->selectRaw("CASE WHEN LENGTH(gravacoes_s3.path_s3) > 0 AND cs.listen_records = 1 THEN cdr.uuid END AS uuid");
            } else {
                $query
                    ->selectRaw("CASE WHEN LENGTH(gravacoes_s3.path_s3) > 0 THEN cdr.uuid END AS uuid");
            }
            $query
                ->selectRaw('CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END as cliente')
                ->selectRaw("CONCAT((cdr.billsec) DIV 60, ':', LPAD((FLOOR(cdr.billsec) MOD 60), 2, 0)) AS 'duration'")
                ->from((env('DB_DATABASE_LEGACY') . '.tblcustomfieldsvalues as context'))
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
                })->leftjoin(env('DB_DATABASE_VOIP') . ".gravacoes_s3", 'cdr.uuid', '=', 'gravacoes_s3.uuid');

                if ($currentUser) {
                    $query->where('u.id', '=',  $currentUser->id);
                }
        })->select(['us_id', 'customer_id', 'start_time', 'origin_number', 'destination_number', 'uuid', 'cliente', 'duration']);
    }
}
