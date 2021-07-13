<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientHeightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_heights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->nullable();
            $table->date('date');
            $table->float('height');
            $table->string('unit')->nullable();
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
        Schema::dropIfExists('patient_heights');
    }
}
