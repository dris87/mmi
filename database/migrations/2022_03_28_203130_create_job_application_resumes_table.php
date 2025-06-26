<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_application_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_application_id');
            $table->unsignedBigInteger('media_id');
            $table->timestamps();

            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_application_resumes');
    }
}
