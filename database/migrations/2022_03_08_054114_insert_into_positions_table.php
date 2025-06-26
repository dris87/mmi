<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertIntoPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $input = [
            ['name' => 'Vezérigazgató',],
            ['name' => 'Tulajdonos',],
            ['name' => 'PR Vezető',],
            ['name' => 'Gazdasági igazgató',],
            ['name' => 'HR Vezető',],
            ['name' => 'Vezetői asszisztens',],
            ['name' => 'Projekt Manager',],
        ];

        foreach ($input as $data) {
            \App\Models\Position::create($data);
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
