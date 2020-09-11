<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {

    return [
        'hospital_id' => $faker->word,
        'name' => $faker->word,
        'short_code' => $faker->word,
        'telephone_1' => $faker->text,
        'telephone_2' => $faker->text,
        'telephone_3' => $faker->text,
        'address' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
