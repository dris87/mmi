<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CandidateJobTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_job_type', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('job_type_id')->nullable(true);
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->timestamps();

            $table->foreign('job_type_id')->references('id')->on('job_types');
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
