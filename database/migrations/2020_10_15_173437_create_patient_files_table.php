<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('disease_id')->constrained('diseases');
            $table->tinyInteger('is_active')->default(1);
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->foreignId('branch_id')->constrained('branches');
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
        Schema::dropIfExists('patient_files');
    }
}
