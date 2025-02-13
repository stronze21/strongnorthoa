<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInSsplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sspls', function (Blueprint $table) {
            $table->enum('type', ['lifechanger', 'partner'])->default('lifechanger')->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sspls', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}