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
            $table->string('occupation')->nullable();
            $table->string('current_level')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('civil_status')->nullable();
            $table->date('cs_date')->nullable();
            $table->decimal('amount_invested')->nullable();
            $table->date('sign_up_date')->nullable();
            $table->foreignIdFor(User::class, 'team_leader')->constrained('users')->references('user_id')->nullable();
            $table->foreignIdFor(User::class, 'team_builder')->constrained('users')->references('user_id')->nullable();
            $table->foreignIdFor(User::class, 'distributor')->constrained('users')->references('user_id')->nullable();
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
