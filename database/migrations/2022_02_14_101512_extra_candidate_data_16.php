<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData16 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $obj = new \App\Models\SkillLevel();
        $obj->id = 1;
        $obj->name = "Kezdő";
        $obj->save();

        $obj = new \App\Models\SkillLevel();
        $obj->id = 2;
        $obj->name = "Középhaladó";
        $obj->save();

        $obj = new \App\Models\SkillLevel();
        $obj->id = 3;
        $obj->name = "Haldó";
        $obj->save();

        $obj = new \App\Models\SkillLevel();
        $obj->id = 4;
        $obj->name = "Szakértő";
        $obj->save();

        Schema::table('candidate_basic_it_skills', function (Blueprint $table) {

            $table->dropForeign('candidate_basic_it_skills_basic_it_skill_id_foreign');
            $table->dropColumn('basic_it_skill_id');
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
