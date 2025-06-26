<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'marital_status' => 'Házas',
                'description'    => 'Házas',
            ],
            [
                'marital_status' => 'Özvegy',
                'description'    => 'Özvegy',
            ],
            [
                'marital_status' => 'Elvált',
                'description'    => 'Elvált',
            ],
            [
                'marital_status' => 'Egyedülálló',
                'description'    => 'Egyedülálló',
            ],
        ];

        foreach ($input as $data) {
            MaritalStatus::create($data);
        }
    }
}
