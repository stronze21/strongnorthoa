<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetails2ToOrderAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_agreements', function (Blueprint $table) {
            $table->decimal('price_diff')->nullable();
            $table->decimal('price_override')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_agreements', function (Blueprint $table) {
            $table->dropColumn('price_diff', 'price_override');
        });
    }
}
