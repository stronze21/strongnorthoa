<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHostMiddlenameToCreationShows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooking_shows', function (Blueprint $table) {
            $table->string('host_middlename')->nullable()->after('host_surename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cooking_shows', function (Blueprint $table) {
            $table->dropColumn('host_middlename');
        });
    }
}
