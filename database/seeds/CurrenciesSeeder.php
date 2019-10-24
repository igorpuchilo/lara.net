<?php

use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'title' => 'Belarussian Ruble',
                'code' => 'BYN',
                'symbol_left' => '',
                'symbol_right' => 'бел.руб.',
                'value' => '2.1',
                'base' => '0'
            ],
            [
                'id' => '2',
                'title' => 'Dollar',
                'code' => 'USD',
                'symbol_left' => '$',
                'symbol_right' => '',
                'value' => '1.00',
                'base' => '1'
            ],
            [
                'id' => '3',
                'title' => 'Euro',
                'code' => 'EUR',
                'symbol_left' => '€',
                'symbol_right' => '',
                'value' => '0.88',
                'base' => '0'
            ],

        ];

        DB::table('currencies')->insert($data);
    }
}
