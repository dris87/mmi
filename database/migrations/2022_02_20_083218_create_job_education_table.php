<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->string('name');
            $table->unsignedInteger('degree_level_id');
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('degree_level_id')->references('id')->on('required_degree_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_education');
    }
}
