<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('candidate_status', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->nullable(false);
            $table->timestamps();
        });

        Schema::table('candidates', function (Blueprint $table) {
            $table->unsignedBigInteger('candidate_status_id')->after("user_id")->nullable(true);
            $table->foreign('candidate_status_id')->references('id')->on('candidate_status');
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
