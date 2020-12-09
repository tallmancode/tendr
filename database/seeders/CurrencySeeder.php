<?php

namespace Database\Seeders;

use App\Models\Settings\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    const DATA = [
        [
            'name' => 'Dollars',
            'code' => 'USD',
            'symbol' => '$',
        ],
        [
            'name' => 'Pounds',
            'code' => 'EGP',
            'symbol' => '£',
        ],
        [
            'name' => 'Rands',
            'code' => 'ZAR',
            'symbol' => 'R',
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::DATA as $currency) {
            Currency::create($currency);
        }
    }
}
