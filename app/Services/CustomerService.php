<?php
namespace App\Services;

use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function find()
    {
        return DB::table(DB::raw(env('DB_DATABASE'). '.customers c'))
            ->select(['c.id', 'c.code'])
            ->selectRaw("CASE WHEN co.id IS NOT NULL THEN co.social_reason ELSE u.name END AS name")
            ->selectRaw("CASE WHEN co.id IS NOT NULL THEN co.cnpj ELSE u.cpf END AS document")
            ->addSelect(['c.created_at'])
            ->leftJoin(env('DB_DATABASE').'.companies AS co', function (JoinClause $join){
                $join->on('co.id', '=', 'c.typeable_id')
                    ->where("c.typeable_type", '=', $typeableType = "App\\Company");
            })
            ->leftJoin(env('DB_DATABASE').'.users AS u', function (JoinClause $join){
                $join->on('u.id', '=', 'c.typeable_id')
                    ->where("c.typeable_type", '=', $typeableType = "App\\User");
            });
    }
}
