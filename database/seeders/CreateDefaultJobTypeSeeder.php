<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Seeder;

class CreateDefaultJobTypeSeeder extends Seeder
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
                'name'        => 'Alkalmazotti Státusz',
                'description' => 'Alkalmazotti Státusz',
            ],
            [
                'name'        => 'Alvállalkozói státusz',
                'description' => 'Alvállalkozói Státusz',
            ],
        ];

        foreach ($input as $data) {
            JobType::create($data);
        }
    }
}
