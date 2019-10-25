<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'code' => $faker->numerify('#######'),
        'typeable_type' => \App\Company::class,
    ];
});

$factory->afterMaking(Customer::class, function ($customer, $faker) {

    $customer->typeable()->associate(factory($customer->typeable_type)->create());
});
