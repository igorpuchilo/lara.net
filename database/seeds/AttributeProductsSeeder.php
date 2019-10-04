<?php

use Illuminate\Database\Seeder;

class AttributeProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];


        for ($i = 1; $i <= 12; $i+=4){
            for ($j = 1; $j <= 10; $j++) {
                $data[] = [
                    'product_id' => $j,
                    'attr_id' => $i,
                ];
            }
        }
        DB::table('attribute_products')->insert($data);
    }
}
