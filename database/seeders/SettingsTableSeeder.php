<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageUrl = 'assets/img/main-logo.png';
        $favicon = 'favicon.ico';

        Setting::create(['key' => 'application_name', 'value' => 'Mumi.hu']);
        Setting::create(['key' => 'logo', 'value' => $imageUrl]);
        Setting::create(['key' => 'favicon', 'value' => $favicon]);
        Setting::create(['key' => 'company_description', 'value' => 'Mumi.hu - Munkalehetőség Mindenkinek Kft.']);
        Setting::create([
            'key'   => 'address',
            'value' => '2800 Tatabánya, Fő tér 20',
        ]);
        Setting::create(['key' => 'phone', 'value' => '+36 30 345 7061']);
        Setting::create(['key' => 'email', 'value' => 'ugyfelszolgalat@imumi.hu']);
        Setting::create(['key' => 'facebook_url', 'value' => 'https://www.facebook.com/mumi/']);
        Setting::create(['key' => 'twitter_url', 'value' => 'https://twitter.com/mumi?lang=en']);
        Setting::create(['key' => 'google_plus_url', 'value' => 'https://mumi.hu/']);
        Setting::create([
            'key'   => 'linkedIn_url',
            'value' => '',
        ]);
        Setting::create([
            'key' => 'about_us', 'value' => 'A www.mumi.hu, egy olyan egyedi és speciális állásportál, amely országosan fogja össze az állást keresőket és váltani kívánókat. A Munkalehetőség Mindenkinek Kft. működése és filozófiája teljes mértékben eltér a munkaerőpiac jelenleg ismert szereplőitől.',
        ]);
    }
}
