<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Nurse;
use Faker\Generator as Faker;

$factory->define(Nurse::class, function (Faker $faker) {

    return [
        'nurse_number' => $faker->randomDigitNotNull,
        'nurse_code' => $faker->word,
        'nurse_name' => $faker->word,
        'nurse_image' => $faker->text,
        'title_id' => $faker->word,
        'gender_id' => $faker->word,
        'dob' => $faker->word,
        'country_id' => $faker->word,
        'nationality_id' => $faker->word,
        'passport_no' => $faker->word,
        'mobile' => $faker->word,
        'telephone' => $faker->word,
        'address' => $faker->word,
        'email' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
