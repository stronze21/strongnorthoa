<?php

use App\Models\Region;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->string('m_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->foreignIdFor(Region::class, 'region_id')->nullable();
            $table->foreignIdFor(Province::class, 'province_id')->nullable();
            $table->foreignIdFor(Municipality::class, 'municipality_id')->nullable();
            $table->text('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('f_name', 'l_name', 'm_name', 'birth_date', 'region_id', 'province_id', 'municipality_id', 'address');
        });
    }
}