<?php

use Illuminate\Database\Seeder;

class AdminOrderProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];


        for ($i = 1; $i <= 12; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $data[] = [
                    'order_id' => $i,
                    'product_id' => $j,
                    'qty' => rand(1,4),
                    'title' => 'Michelin Tyres test',
                    'price' => rand(75,1250),
                ];
            }
        }


        DB::table('order_products')->insert($data);
    }
}
