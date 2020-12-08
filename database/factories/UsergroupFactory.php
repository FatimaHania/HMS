<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Usergroup;
use Faker\Generator as Faker;

$factory->define(Usergroup::class, function (Faker $faker) {

    return [
        'description' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
