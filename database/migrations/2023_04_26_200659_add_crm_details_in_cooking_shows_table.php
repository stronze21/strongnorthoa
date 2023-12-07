<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCrmDetailsInCookingShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooking_shows', function (Blueprint $table) {
            $table->string('host_surename')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city_town')->nullable();
            $table->string('province')->nullable();
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
            $table->dropColumn('host_surename', 'address_2', 'city_town', 'province');
        });
    }
}
