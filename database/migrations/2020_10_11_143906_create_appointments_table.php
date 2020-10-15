<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); 
            $table->integer('reference_number')->default(0);
            $table->string('reference_code')->nullable();
            $table->foreignId('session_id')->constrained('sessions');
            $table->foreignId('patient_id')->constrained('patients');
            $table->integer('appointment_number')->default(0);
            $table->time('appointment_time')->nullable();
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->decimal('amount');
            $table->tinyInteger('is_paid')->default(0);
            $table->timestamp('attended_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
