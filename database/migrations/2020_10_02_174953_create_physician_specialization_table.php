<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicianSpecializationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physician_specialization', function (Blueprint $table) {
            $table->id();
            $table->foreignId('physician_id')->contrained('physicians');
            $table->foreignId('specialization_id')->constrained('specializations');
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
        Schema::dropIfExists('physician_specialization');
    }
}
