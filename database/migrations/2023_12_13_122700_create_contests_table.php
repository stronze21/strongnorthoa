<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('shows')->default('0');
            $table->decimal('sales', 18, 2)->default('0');
            $table->decimal('sets')->default('0');
            $table->boolean('strict')->nullable();
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
        Schema::dropIfExists('contests');
    }
}
