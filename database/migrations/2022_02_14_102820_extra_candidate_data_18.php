<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData18 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidate_software_skills', function (Blueprint $table) {

            $table->dropForeign('candidate_software_skills_software_skill_id_foreign');
            $table->dropColumn('software_skill_id');
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
