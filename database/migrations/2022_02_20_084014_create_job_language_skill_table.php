<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobLanguageSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_language_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('language_id');
            $table->unsignedBigInteger('language_level_id');
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('language_level_id')->references('id')->on('language_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_language_skill');
    }
}
