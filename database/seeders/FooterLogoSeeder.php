<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\SalaryCurrency;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class FooterLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageUrl = 'assets/img/main-logo.png';

        Setting::create(['key' => 'footer_logo', 'value' => $imageUrl]);
    }
}
