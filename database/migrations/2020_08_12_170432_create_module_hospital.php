<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleHospital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_hospital', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->foreignId('module_id')->nullable()->constrained('modules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_hospital');
    }
}
