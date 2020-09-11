<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DocumentCode;
use Faker\Generator as Faker;

$factory->define(DocumentCode::class, function (Faker $faker) {

    return [
        'documentcode_id' => $faker->word,
        'short_code' => $faker->word,
        'description' => $faker->word,
        'prefix' => $faker->word,
        'starting_no' => $faker->randomDigitNotNull,
        'format_length' => $faker->randomDigitNotNull,
        'common_difference' => $faker->randomDigitNotNull,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
