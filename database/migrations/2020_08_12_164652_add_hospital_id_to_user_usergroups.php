<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHospitalIdToUserUsergroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_usergroup', function (Blueprint $table) {
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_usergroups', function (Blueprint $table) {
            //
        });
    }
}
