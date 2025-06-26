<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CandidateJobCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_job_category', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('job_category_id')->nullable(true);
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->timestamps();

            $table->foreign('job_category_id')->references('id')->on('job_categories');
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
