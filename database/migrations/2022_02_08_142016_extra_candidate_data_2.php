<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_extra_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->text('driving_licence')->nullable(true);
            $table->text('bacis_it_skills')->nullable(true);
            $table->text('advanced_it_skills')->nullable(true);
            $table->text('hobbies')->nullable(true);
            $table->text('other_comments')->nullable(true);
            $table->timestamps();

            $table->foreign('candidate_id')->references('id')->on('candidates');
        });

        Schema::create('extra_requirements', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('driving_licence')->nullable(true);
            $table->timestamps();
        });

        Schema::create('candidate_extra_requirements', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('candidate_id')->nullable(true);
            $table->unsignedBigInteger('requirement_id')->nullable(false);
            $table->timestamps();

            $table->foreign('requirement_id')->references('id')->on('extra_requirements');
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
