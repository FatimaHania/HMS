<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Designation;
use Faker\Generator as Faker;

$factory->define(Designation::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'short_code' => $faker->word,
        'description' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
