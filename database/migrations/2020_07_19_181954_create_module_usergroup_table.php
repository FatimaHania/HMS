<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleUsergroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_usergroup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usergroup_id')->nullable()->constrained('usergroups');
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
        Schema::dropIfExists('module_usergroup');
    }
}
