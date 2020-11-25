<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PatientFile;
use Faker\Generator as Faker;

$factory->define(PatientFile::class, function (Faker $faker) {

    return [
        'file_name' => $faker->word,
        'description' => $faker->text,
        'patient_id' => $faker->word,
        'department_id' => $faker->word,
        'disease_id' => $faker->word,
        'is_active' => $faker->word,
        'hospital_id' => $faker->word,
        'branch_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
