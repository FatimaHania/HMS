<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentcodes', function (Blueprint $table) {
            $table->id();
            $table->string('short_code');
            $table->string('description');
            $table->string('prefix');
            $table->integer('starting_no');
            $table->integer('format_length');
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
        Schema::dropIfExists('documentcodes');
    }
}
