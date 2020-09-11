<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {

    return [
        'patient_code' => $faker->word,
        'patient_name' => $faker->word,
        'patient_image' => $faker->word,
        'title_id' => $faker->word,
        'gender_id' => $faker->word,
        'dob' => $faker->word,
        'dod' => $faker->word,
        'country_id' => $faker->word,
        'nationality_id' => $faker->word,
        'passport_no' => $faker->word,
        'mobile' => $faker->word,
        'telephone' => $faker->word,
        'address' => $faker->word,
        'email' => $faker->word,
        'bloodgroup_id' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
