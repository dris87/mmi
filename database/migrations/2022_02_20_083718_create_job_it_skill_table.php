<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobItSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_it_skill', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->string('name');
            $table->unsignedBigInteger('skill_level_id');
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('skill_level_id')->references('id')->on('skill_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_it_skill');
    }
}
