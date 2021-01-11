<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkVerificationColumnsInUserHospital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_hospital', function (Blueprint $table) {
            $table->string('link_verification_token')->nullable()->after('branch_id');
            $table->datetime('link_verified_at')->nullable()->after('branch_id');
            $table->tinyInteger('is_approved_by_hospital')->default('0')->after('branch_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_hospital', function (Blueprint $table) {
            //
        });
    }
}
