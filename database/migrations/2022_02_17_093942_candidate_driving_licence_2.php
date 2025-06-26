<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CandidateDrivingLicence2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $input = [
            ['name' => 'A',],
            ['name' => 'A1',],
            ['name' => 'A2',],
            ['name' => 'A1/B',],
            ['name' => 'AM',],
            ['name' => 'B',],
            ['name' => 'C',],
            ['name' => 'D',],
            ['name' => 'E',],
            ['name' => 'B + E',],
            ['name' => 'C + E',],
            ['name' => 'D + E',],
            ['name' => 'K',],
            ['name' => 'T',],
            ['name' => 'TR',],
            ['name' => 'V',],
        ];

        foreach ($input as $data) {
            \App\Models\DrivingLicences::create($data);
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
