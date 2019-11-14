<?php
namespace App\Services;

use App\Company;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function find()
    {
        return DB::table(env('DB_DATABASE_LEGACY'). '.tblinvoices AS i')
            ->select(["i.id AS code", "date", "duedate", "total"])
            ->selectRaw("CASE WHEN status = 'Unpaid' AND duedate <= now() THEN 'Em atraso'
                            WHEN status = 'Unpaid' AND duedate > now() THEN 'Em aberto'
                            WHEN status = 'Paid' THEN 'Pago'
                            WHEN status = 'Cancelled' THEN 'Cancelada'
                            ELSE status END 
                        AS status")
            ->selectRaw("CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END as client")
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


        "SELECT i.id AS codigo_fatura,
       i.date AS data,
       duedate AS vencimento,
       total AS valor,
       CASE WHEN status = 'Unpaid' AND duedate <= now() THEN 'Em atraso'
            WHEN status = 'Unpaid' AND duedate > now() THEN 'Em aberto'
            WHEN status = 'Paid' THEN 'Pago'
            WHEN status = 'Cancelled' THEN 'Cancelada'
            ELSE status END 
         AS status,
       CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END as cliente
FROM voxlink_whmcs_dev.tblinvoices i
JOIN laravel.customers c ON c.code = i.userid
LEFT JOIN laravel.companies co ON co.id = c.typeable_id AND c.typeable_type = 'App\\Company'
LEFT JOIN laravel.users u ON u.id = c.typeable_id AND c.typeable_type = 'App\\User'
JOIN laravel.customer_user cu ON cu.customer_id = c.id
WHERE cu.user_id = ? -- Filtro pelo usuário logado, default para ! admin
    AND (c.typeable_id = ? AND c.typeable_type = ?) -- Filtro pelo customer do usuário logado
    AND (status = ? AND duedate <= now() ) -- filtro por status = em atraso
    AND (status = ? AND duedate > now() ) -- filtro por status = Em aberto
    AND (status = ?) -- Filtro por status = Pago ou Cancelada,
  AND duedate = ? -- Filtro pela data de vencimento
    AND i.id = ? -- Filtro pelo código da fatura
    AND i.date = ? -- Filtro pelo código da fatura";
    }
}
