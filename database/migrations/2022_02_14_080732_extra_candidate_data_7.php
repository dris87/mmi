<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('language_level', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->nullable(false);
            $table->timestamps();
        });

        Schema::table('candidate_language', function (Blueprint $table) {
            $table->unsignedBigInteger('language_level_id')->nullable(true)->after("language_id");
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
        //
    }
}
