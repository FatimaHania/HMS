<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Hospital;
use Faker\Generator as Faker;

$factory->define(Hospital::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'short_code' => $faker->word,
        'logo' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
