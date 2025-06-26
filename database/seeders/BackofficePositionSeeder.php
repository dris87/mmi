<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BackofficePosition;

class BackofficePositionSeeder extends Seeder
{
    const BACKOFFICE_POSITIONS = [
        'IT',
        'Könyvelő',
        'Backoffice vezető',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::BACKOFFICE_POSITIONS as $backofficePosition) {
            BackofficePosition::create([
                'name' => $backofficePosition
            ]);
        }
    }
}
