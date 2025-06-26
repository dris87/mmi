<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CandidateJobShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_job_shift', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('job_shift_id')->nullable(true);
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->timestamps();

            $table->foreign('job_shift_id')->references('id')->on('job_shifts');
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
