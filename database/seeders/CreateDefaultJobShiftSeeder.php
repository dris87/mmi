<?php

namespace Database\Seeders;

use App\Models\JobShift;
use Illuminate\Database\Seeder;

class CreateDefaultJobShiftSeeder extends Seeder
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
                'shift'       => 'Délelőtti műszak',
                'description' => 'Délelőtti műszak',
            ], [
                'shift'       => 'Délutáni műszak',
                'description' => 'Délutáni műszak',
            ], [
                'shift'       => 'Esti műszak',
                'description' => 'Esti műszak',
            ], [
                'shift'       => 'Teljes műszak',
                'description' => 'Teljes műszak',
            ]
        ];

        foreach ($input as $data) {
            JobShift::create($data);
        }
    }
}
