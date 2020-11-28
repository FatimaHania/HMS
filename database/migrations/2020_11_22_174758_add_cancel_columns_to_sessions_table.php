<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelColumnsToSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId('started_by')->nullable()->constrained('users')->after('starts_at');
            $table->foreignId('completed_by')->nullable()->constrained('users')->after('completed_at');
            $table->date('cancelled_date')->nullable()->after('is_cancelled');
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->after('is_cancelled');
            $table->longText('cancelled_reason')->nullable()->after('is_cancelled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            //
        });
    }
}
