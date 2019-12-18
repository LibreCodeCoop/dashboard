<?php

namespace App;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CustomerLegacy
{
    public function __construct()
    {
        $this->faker = Faker::create('pt_BR');
    }

    public function find(int $code = 0){

        return DB::connection('legacy')
            ->table('tblclients')
            ->select('firstname', 'lastname', 'tblclients.id as code', 'companyname as social_reason', DB::raw("concat(address1,'".env(  'APP_ADDRESS_SEPARATOR', ' - ')."',address2) as address"), 'city', 'state',
                    'postcode', 'country', 'phonenumber as phone', 'tblcustomfieldsvalues.value AS cnpj_cpf')
            ->join('tblcustomfieldsvalues', function ($join) {
                $join->on('tblclients.id', '=', 'tblcustomfieldsvalues.relid')
                    ->where('tblcustomfieldsvalues.fieldid', 1);
            })
            ->where('tblclients.id', $code)
            ->get()
            ->first();
    }
}
