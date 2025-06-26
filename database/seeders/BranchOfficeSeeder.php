<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BranchOffice;

class BranchOfficeSeeder extends Seeder
{
    const BRANCH_OFFICES = [
        'Központi Iroda',
        'Központi Raktár',
        'Debreceni Iroda',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::BRANCH_OFFICES as $branchOfficeName) {
            BranchOffice::create([
                'name' => $branchOfficeName
            ]);
        }
    }
}
