<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CandidateSituationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $input = [
            ['name' => 'Alkalmazott',],
            ['name' => 'Pályakezdő',],
            ['name' => 'Gyakornok',],
            ['name' => 'Munkanélküli',],
            ['name' => 'Megváltozott munkaképességű',],
            ['name' => 'Nyugdíjas',],
            ['name' => 'GYED/GYES/GYET',],
            ['name' => 'Vállalkozó',],
            ['name' => 'Tanuló',],
            ['name' => 'Projektmunkát vállaló',],
            ['name' => 'Tartós munkanélküli ',],
            ['name' => 'Segélyen élő',],
            ['name' => 'Háztartásbeli',]
        ];

        foreach ($input as $data) {
            \App\Models\Circumstances::create($data);
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
