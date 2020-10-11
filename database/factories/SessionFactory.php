<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Session;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {

    return [
        'physician_id' => $faker->word,
        'name' => $faker->word,
        'date' => $faker->word,
        'start_time' => $faker->word,
        'end_time' => $faker->word,
        'number_of_slots' => $faker->randomDigitNotNull,
        'duration_per_slot' => $faker->randomDigitNotNull,
        'department_id' => $faker->word,
        'room_id' => $faker->word,
        'currency_id' => $faker->word,
        'amount_per_slot' => $faker->word,
        'starts_at' => $faker->date('Y-m-d H:i:s'),
        'completed_at' => $faker->date('Y-m-d H:i:s'),
        'is_cancelled' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
