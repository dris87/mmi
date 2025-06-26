<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'language' => 'Magyar',
                'iso_code' => 'hun',
            ],
            [
                'language' => 'Angol',
                'iso_code' => 'eng',
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
