<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountSoldInCookingShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooking_shows', function (Blueprint $table) {
            $table->decimal('amount_sold', 18, 2)->default('0')->nullable();
            $table->decimal('set_amount', 18, 2)->default('375000.00')->nullable();
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
            $table->dropColumn('amount_sold', 'set_amount');
        });
    }
}
