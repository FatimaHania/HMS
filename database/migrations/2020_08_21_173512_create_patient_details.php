<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name')->nullable();
            $table->binary('patient_image');
            $table->integer('title_id');
            $table->integer('gender_id');
            $table->date('dob');
            $table->date('dod');
            $table->integer('country_id');
            $table->integer('nationality_id');
            $table->string('passport_no');
            $table->string('mobile');
            $table->string('telephone');
            $table->string('address');
            $table->string('email');
            $table->string('bloodgroup_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
