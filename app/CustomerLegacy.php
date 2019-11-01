<?php

namespace App;
use Faker\Factory as Faker;

class CustomerLegacy
{
    public function __construct()
    {
        $this->faker = Faker::create('pt_BR');
    }

    public function find(int $code = 0){
        return (object) [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'code' => $code, //id
            'social_reason' => $this->faker->company, //companyname
            'municipal_registration' => $this->faker->numerify("#########"),
            'address' => $this->faker->address, //address1 + address2
            'city' => $this->faker->city,
            'state' => $this->faker->numerify("#########"),
            'postcode' => $this->faker->postcode,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber, //phonenumber
            'cnpj_cpf' => ($this->faker->boolean)? $this->faker->cpf : $this->faker->cnpj,
        ];
    }
}
