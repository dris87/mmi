<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCandidate1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {

            $table->unsignedInteger('postcode_id')->nullable()->after('nationality');
            $table->unsignedBigInteger('city_id')->nullable()->after('postcode_id');
            $table->text('personal_competencies')->nullable()->after('address');
            $table->text('hobbies')->nullable()->after('personal_competencies');

            $table->foreign('postcode_id')->references('id')->on('postal_codes');
            $table->foreign('city_id')->references('id')->on('cities');
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
