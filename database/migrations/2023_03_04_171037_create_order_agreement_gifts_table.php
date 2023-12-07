<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAgreementGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_agreement_gifts', function (Blueprint $table) {
            $table->id();
            $table->string('order_agreement_id');
            $table->string('product_id');
            $table->decimal('item_price', 18, 2);
            $table->integer('item_qty');
            $table->decimal('item_total', 18, 2);
            $table->string('type');
            $table->string('status')->default('Pending');
            $table->string('remarks')->nullable();
            $table->integer('released')->nullable()->default(0);
            $table->integer('returned')->nullable()->default(0);
            $table->string('tblset_id')->nullable();
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
        Schema::dropIfExists('order_agreement_gifts');
    }
}
