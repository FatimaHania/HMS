<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->nullable();
            $table->foreignId('appointment_id')->constrained('appointments')->nullable();
            $table->longText('complains')->nullable();
            $table->longText('observations')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->longText('treatment')->nullable();
            $table->longText('prescription')->nullable();
            $table->longText('attachment')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('checkups');
    }
}
