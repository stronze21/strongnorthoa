<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_agreements', function (Blueprint $table) {
            $table->id();
            $table->string('oa_number')->nullable();
            $table->string('cs_id');
            $table->string('date');
            $table->string('client');
            $table->string('address');
            $table->string('contact');
            $table->string('consultant')->nullable();
            $table->string('associate')->nullable();
            $table->string('presenter')->nullable();
            $table->string('team_builder')->nullable();
            $table->string('distributor')->nullable();
            $table->string('user_id');
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('order_agreements');
    }
}
