<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Bejárás támogatása ";
        $obj->save();

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Céges busz";
        $obj->save();

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Céges autó";
        $obj->save();

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Céges laptop";
        $obj->save();

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Céges telefon";
        $obj->save();

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Albérlet támogatás";
        $obj->save();

        $obj = new \App\Models\ExtraRequirements();
        $obj->name = "Céges szállás";
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
