<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddPositionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->date('dob')->nullable()->change();
            $table->integer('gender')->nullable()->change();
            $table->bigInteger('country_id')->nullable()->change();
            $table->bigInteger('state_id')->nullable()->change();
            $table->bigInteger('city_id')->nullable()->change();
            $table->string('position')->nullable()->after('phone');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
