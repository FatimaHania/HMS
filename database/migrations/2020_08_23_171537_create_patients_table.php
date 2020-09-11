<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
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
            $table->string('patient_code')->nullable();
            $table->string('patient_name')->nullable();
            $table->longText('patient_image')->nullable();
            $table->foreignId('title_id')->constrained('titles')->nullable();
            $table->foreignId('gender_id')->constrained('genders')->nullable();
            $table->date('dob')->nullable();
            $table->date('dod')->nullable();
            $table->foreignId('country_id')->constrained('countries')->nullable();
            $table->foreignId('nationality_id')->constrained('nationalities')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('bloodgroup_id')->constrained('bloodgroups')->nullable();
            $table->foreignId('hospital_id')->constrained('hospitals')->nullable();
            $table->foreignId('branch_id')->constrained('branches')->nullable();
            $table->timestamps(0);
            $table->softDeletes('deleted_at', 0);
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
