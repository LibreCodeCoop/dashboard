<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'social_reason' => $faker->company,
        'municipal_registration' => $faker->numerify('###########'),
        'state' => $faker->state,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});



