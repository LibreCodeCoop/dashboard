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
        $sub = DB::table((env('DB_DATABASE_LEGACY') . '.tblcustomfieldsvalues as context'));
        $sub
            ->select([
                'd.userid AS code',
                'context.value AS dominio',
                'cs.listen_records'
            ]);
        $sub
            ->selectRaw('CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END as client')
            ->from((env('DB_DATABASE_LEGACY') . '.tblcustomfieldsvalues as context'))
            ->join(env('DB_DATABASE_LEGACY') . ".tblcustomfields as context_field", function (JoinClause $join) {
                $join->on('context_field.id', '=', 'context.fieldid')
                    ->where("context_field.fieldname", '=', 'Dominio no PABX');
            })
            ->join(env('DB_DATABASE_LEGACY') . ".tblhosting as d", 'd.id', '=', 'context.relid')
            ->join(env('DB_DATABASE') . ".customers as cs", 'cs.code', '=', 'd.userid')
            ->leftjoin(env('DB_DATABASE') . ".companies as co", function ($join) {
                $join->on('co.id', '=', 'cs.typeable_id')
                    ->where("cs.typeable_type", '=', $typeableType = "App\Company");
            })
            ->leftjoin(env('DB_DATABASE') . ".users as u", function ($join) {
                $join->on('u.id', '=', 'cs.typeable_id')
                    ->where('cs.typeable_type', '=', $typeableType = "App\User");
            });
        if ($currentUser) {
            $sub
                ->join(env('DB_DATABASE') . ".customer_user as cu", 'cu.customer_id', '=', 'cs.id')
                ->where('cu.user_id', '=',  $currentUser->id);
        }
        $query = DB::table( DB::raw("({$sub->toSql()}) as client") )
            ->select([
                'client.client',
                'client.dominio',
                'cdr.start_stamp as start_time'
            ])
            ->addSelect([
                'cdr.caller_id_number as origin_number',
                'cdr.destination_number'
            ])
            ->selectRaw("CONCAT((cdr.billsec) DIV 60, ':', LPAD((FLOOR(cdr.billsec) MOD 60), 2, 0)) AS 'duration'");
        if ($currentUser) {
            $query
                ->selectRaw("CASE WHEN LENGTH(gravacoes_s3.path_s3) > 0 AND client.listen_records = 1 THEN cdr.uuid END AS uuid");
        } else {
            $query
                ->selectRaw("CASE WHEN LENGTH(gravacoes_s3.path_s3) > 0 THEN cdr.uuid END AS uuid");
        }
        $query
            ->join(env('DB_DATABASE_VOIP') . ".cdr_report as cdr", function (JoinClause $join) {
                $join->on('cdr.dominio', '=', 'client.dominio');
            })->leftjoin(env('DB_DATABASE_VOIP') . ".gravacoes_s3", 'cdr.uuid', '=', 'gravacoes_s3.uuid')
            ->mergeBindings($sub);
        return $query;
    }
}
