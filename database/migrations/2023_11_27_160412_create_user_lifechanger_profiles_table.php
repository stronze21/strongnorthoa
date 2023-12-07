<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLifechangerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lifechanger_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->references('user_id');
            $table->string('occupation');
            $table->string('current_level');
            $table->foreignIdFor(User::class, 'team_builder')->constrained('users')->references('user_id');
            $table->foreignIdFor(User::class, 'distributor')->constrained('users')->references('user_id');
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
        Schema::dropIfExists('user_lifechanger_profiles');
    }
}
