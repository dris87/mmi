<?php

namespace Database\Seeders;

use App\Models\RequiredDegreeLevel;
use Illuminate\Database\Seeder;

class CreateDefaultDegreeLevelSeeder extends Seeder
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
                'name' => 'Alapfokú végzettség',
            ],
            [
                'name' => 'Középfokú végzettség',
            ],
            [
                'name' => 'Felsőfokú végzettség',
            ],
        ];

        foreach ($input as $data) {
            RequiredDegreeLevel::create($data);
        }
    }
}
