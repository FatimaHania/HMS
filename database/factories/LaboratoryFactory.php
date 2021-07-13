<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Laboratory;
use Faker\Generator as Faker;

$factory->define(Laboratory::class, function (Faker $faker) {

    return [
        'lab_number' => $faker->randomDigitNotNull,
        'lab_code' => $faker->word,
        'name' => $faker->word,
        'short_code' => $faker->word,
        'address' => $faker->word,
        'telephone_1' => $faker->word,
        'telephone_2' => $faker->word,
        'email' => $faker->word,
        'is_active' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
