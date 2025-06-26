<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData12 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $obj = new \App\Models\LanguageLevel();
        $obj->name = "Alapfok";
        $obj->save();

        $obj = new \App\Models\LanguageLevel();
        $obj->name = "Középfok";
        $obj->save();

        $obj = new \App\Models\LanguageLevel();
        $obj->name = "Felsőfok";
        $obj->save();

        $obj = new \App\Models\LanguageLevel();
        $obj->name = "Anyanyelvi";
        $obj->save();

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
