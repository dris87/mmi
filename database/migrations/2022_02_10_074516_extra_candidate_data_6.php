<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtraCandidateData6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Aktív/Inaktív/Elhelyezkedett/Nem keres munkát/Javításra vár
        $objCandidateStatus = new \App\Models\CandidateStatus();
        $objCandidateStatus->setId(1);
        $objCandidateStatus->setName("Aktív");
        $objCandidateStatus->save();

        $objCandidateStatus = new \App\Models\CandidateStatus();
        $objCandidateStatus->setId(2);
        $objCandidateStatus->setName("Inaktív");
        $objCandidateStatus->save();

        $objCandidateStatus = new \App\Models\CandidateStatus();
        $objCandidateStatus->setId(3);
        $objCandidateStatus->setName("Elhelyezkedett");
        $objCandidateStatus->save();

        $objCandidateStatus = new \App\Models\CandidateStatus();
        $objCandidateStatus->setId(4);
        $objCandidateStatus->setName("Nem keres munkát");
        $objCandidateStatus->save();

        $objCandidateStatus = new \App\Models\CandidateStatus();
        $objCandidateStatus->setId(5);
        $objCandidateStatus->setName("Javításra vár");
        $objCandidateStatus->save();
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
