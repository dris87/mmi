<?php

use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDefaultServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $services = [
            ['name' => 'Jelentkezések megtekintése', 'price' => 0],
            ['name' => 'Párosítás', 'price' => 0],
            ['name' => 'Bővített szűrő', 'price' => 5000],
            ['name' => 'Kiemelés', 'price' => 5000],
            ['name' => 'Telefonos interjú', 'price' => 5000],
        ];


        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'price' => $service['price'],
            ]);
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
