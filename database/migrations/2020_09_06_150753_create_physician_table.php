<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physicians', function (Blueprint $table) {
            $table->id();
            $table->integer('physician_number')->nullable();
            $table->string('physician_code')->nullable();
            $table->string('physician_name')->nullable();
            $table->longText('physician_image')->nullable();
            $table->foreignId('title_id')->constrained('titles')->nullable();
            $table->foreignId('gender_id')->constrained('genders')->nullable();
            $table->date('dob')->nullable();
            $table->foreignId('country_id')->constrained('countries')->nullable();
            $table->foreignId('nationality_id')->constrained('nationalities')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('physicians');
    }
}
