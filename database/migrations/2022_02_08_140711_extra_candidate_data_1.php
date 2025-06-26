<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->integer("travel_anywhere")->default(0);
            $table->integer("travel_max_distance")->nullable(true);
            $table->integer("move_anywhere")->default(0);
        });

        Schema::create('candidate_able_to_travel_town', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->unsignedBigInteger('city_id')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('candidate_id')->references('id')->on('candidates');
        });

        Schema::create('candidate_able_to_move_town', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->unsignedBigInteger('city_id')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('candidate_id')->references('id')->on('candidates');
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
