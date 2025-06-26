<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->string('position');
            $table->string('years');
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_requirements');
    }
}
