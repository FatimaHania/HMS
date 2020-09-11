<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentcodeHospital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentcode_hospital', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documentcode_id')->constrained('documentcodes');
            $table->string('short_code');
            $table->string('description');
            $table->string('prefix');
            $table->integer('starting_no');
            $table->integer('format_length');
            $table->integer('common_difference');
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->foreignId('branch_id')->constrained('branches');
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
        Schema::dropIfExists('documentcode_hospital');
    }
}
