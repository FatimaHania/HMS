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
            $table->foreignId('started_by')->constrained('users')->default(0)->after('starts_at');
            $table->foreignId('completed_by')->constrained('users')->default(0)->after('completed_at');
            $table->date('cancelled_date')->nullable()->after('is_cancelled');
            $table->foreignId('cancelled_by')->constrained('users')->default(0)->after('is_cancelled');
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
