<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('physician_id')->constrained('physicians');
            $table->string('name');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('number_of_slots');
            $table->integer('duration_per_slot');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->decimal('amount_per_slot');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->tinyInteger('is_cancelled')->default('0');
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
        Schema::dropIfExists('sessions');
    }
}
