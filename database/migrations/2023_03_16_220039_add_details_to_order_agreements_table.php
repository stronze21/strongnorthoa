<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToOrderAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_agreements', function (Blueprint $table) {
            $table->string('current_level')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('initial_investment')->nullable();
            $table->string('terms')->nullable();
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
            $table->dropColumn(['current_level', 'delivery_date', 'delivery_time', 'initial_investment', 'terms']);
        });
    }
}
