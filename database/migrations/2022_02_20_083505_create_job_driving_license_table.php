<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDrivingLicenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_driving_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->unsignedBigInteger('driving_license_id');
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('driving_license_id')->references('id')->on('driving_licences');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_driving_license');
    }
}
