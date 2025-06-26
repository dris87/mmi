<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CandidateJobSkillData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("delete from candidate_skills where id < 1000");
        DB::statement("delete from skills where id < 1000");

        $objSkill = new \App\Models\Skill();
        $objSkill->name = "Jogosítvány";
        $objSkill->description = "Jogosítvány";
        $objSkill->save();

        $objSkill = new \App\Models\Skill();
        $objSkill->name = " Számítógépes ismeretek";
        $objSkill->description = " Számítógépes ismeretek";
        $objSkill->save();

         $objSkill = new \App\Models\Skill();
        $objSkill->name = "Komplex problémamegoldás";
        $objSkill->description = "Komplex problémamegoldás";
        $objSkill->save();

         $objSkill = new \App\Models\Skill();
        $objSkill->name = "Másokkal való együttműködés";
        $objSkill->description = "Másokkal való együttműködés";
        $objSkill->save();

         $objSkill = new \App\Models\Skill();
        $objSkill->name = "Emberek vezetése";
        $objSkill->description = "Emberek vezetése";
        $objSkill->save();


        $objSkill = new \App\Models\Skill();
        $objSkill->name = "Kritikus gondolkodás";
        $objSkill->description = "Kritikus gondolkodás";
        $objSkill->save();

         $objSkill = new \App\Models\Skill();
        $objSkill->name = "Tárgyalástechnika";
        $objSkill->description = "Tárgyalástechnika";
        $objSkill->save();

        $objSkill = new \App\Models\Skill();
        $objSkill->name = "Szolgáltatás orientáltság";
        $objSkill->description = "Szolgáltatás orientáltság";
        $objSkill->save();

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
