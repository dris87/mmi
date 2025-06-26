<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData17 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidate_advanced_it_skills', function (Blueprint $table) {

            $table->dropForeign('candidate_advanced_it_skills_advanced_it_skill_id_foreign');
            $table->dropColumn('advanced_it_skill_id');
            $table->string('skill')->after("id");

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
