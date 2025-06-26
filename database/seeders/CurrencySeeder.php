<?php

namespace Database\Seeders;

use App\Models\SalaryCurrency;
use Illuminate\Database\Seeder;

/**
 * Class CurrencySeeder
 */
class CurrencySeeder extends Seeder
{
    public function run()
    {
        $input = [
            [
                'currency_name' => 'HUF Hungarian Forint',
                'currency_icon' => 'Ft',
                'currency_code' => 'HUF',
            ],
        ];

        $salaryCurrencies = [
            'HUF Forint',
        ];

        foreach ($input as $data) {
            if (in_array($data['currency_name'], $salaryCurrencies)) {
                $salaryCurrency = SalaryCurrency::whereCurrencyName($data['currency_name'])->first();
                if ($salaryCurrency != null) {
                    $salaryCurrency->update([
                        'currency_icon' => $data['currency_icon'], 'currency_code' => $data['currency_code'],
                    ]);
                } else {
                    SalaryCurrency::create($data);
                }
            } else {
                $salaryCurrency = SalaryCurrency::whereCurrencyName($data['currency_name'])->first();
                if ($salaryCurrency != null) {
                    $salaryCurrency->update([
                        'currency_icon' => $data['currency_icon'], 'currency_code' => $data['currency_code'],
                    ]);
                } else {
                    SalaryCurrency::create($data);
                }
            }
        }
    }
}
