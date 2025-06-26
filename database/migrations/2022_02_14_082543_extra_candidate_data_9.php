<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advanced_it_skills', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->nullable(false);
            $table->timestamps();
        });



        Schema::create('candidate_advanced_it_skills', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('advanced_it_skill_id')->nullable(false);
            $table->unsignedBigInteger('skill_level_id')->nullable(false);
            $table->unsignedInteger('candidate_id')->nullable(false);
            $table->timestamps();

            $table->foreign('skill_level_id')->references('id')->on('skill_level');
            $table->foreign('advanced_it_skill_id')->references('id')->on('advanced_it_skills');
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
