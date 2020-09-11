<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bloodgroup;
use Faker\Generator as Faker;

$factory->define(Bloodgroup::class, function (Faker $faker) {

    return [
        'short_code' => $faker->word,
        'description' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
