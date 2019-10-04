<?php

use Illuminate\Database\Seeder;

class GalleriesSeeder extends Seeder
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
                    'img' => 'g'.$i.'-'.$j.'.png',
                ];
            }
        }


        DB::table('galleries')->insert($data);
    }
}
