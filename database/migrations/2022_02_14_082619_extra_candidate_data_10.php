<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_skills', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->nullable(false);
            $table->timestamps();
        });

        Schema::create('candidate_software_skills', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('software_skill_id')->nullable(false);
            $table->unsignedBigInteger('skill_level_id')->nullable(false);
            $table->unsignedInteger('candidate_id')->nullable(false);
            $table->timestamps();

            $table->foreign('skill_level_id')->references('id')->on('skill_level');
            $table->foreign('software_skill_id')->references('id')->on('software_skills');
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
