<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Call;
use Faker\Generator as Faker;
use \Carbon\Carbon;
$factory->define(Call::class, function (Faker $faker) {
    $maxSecoundsToCall = 60 * 60 * 3;
    $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp());
    $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addSeconds($faker->numberBetween(1, $maxSecoundsToCall));

    return [
        'start' => $startDate->format('Y-m-d H:i:s'),
        'end' => $endDate->format('Y-m-d H:i:s'),
        'source_phone' => $faker->phoneNumber,
        'destination_phone' => $faker->phoneNumber,
    ];
});


