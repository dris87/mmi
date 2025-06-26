<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertIntoCoworkerPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $input = [
            ['name' => 'Kapcsolattartó', 'is_default' => 1],
            ['name' => 'Marketing Tanácsadó',],
            ['name' => 'HR Asszisztens',],
            ['name' => 'Grafikus',],
            ['name' => 'Hirdetés kezelő'],
        ];

        foreach ($input as $data) {
            \App\Models\CoworkerPosition::create($data);
        }
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
