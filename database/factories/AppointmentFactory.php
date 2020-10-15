<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Appointment;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {

    return [
        'reference_number' => $faker->randomDigitNotNull,
        'reference_code' => $faker->word,
        'session_id' => $faker->word,
        'patient_id' => $faker->word,
        'appointment_number' => $faker->randomDigitNotNull,
        'appointment_time' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'currency_id' => $faker->word,
        'amount' => $faker->word,
        'is_paid' => $faker->word,
        'attended_at' => $faker->date('Y-m-d H:i:s'),
        'cancelled_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
