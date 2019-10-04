<?php

use Illuminate\Database\Seeder;

class RelatedProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 17; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                $data[] = [
                    'product_id' => $i,
                    'related_id' => $j,
                ];
            }
        }


        DB::table('related_products')->insert($data);
    }
}
