<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1', 'title' => 'Производитель','alias' => 'manufacturer', 'parent_id' => '0', 'keywords' => 'Manufacturer', 'description' => 'Manufacturer'],
            ['id' => '2', 'title' => 'Зимние','alias' => 'winter', 'parent_id' => '1', 'keywords' => 'Winter', 'description' => 'Winter'],
            ['id' => '3', 'title' => 'Летние','alias' => 'summer', 'parent_id' => '1', 'keywords' => 'Summer', 'description' => 'Summer'],
            ['id' => '4', 'title' => 'Всесезонные','alias' => 'all-season', 'parent_id' => '1', 'keywords' => 'All season', 'description' => 'All season'],
            ['id' => '5', 'title' => 'Hankook','alias' => 'hankook', 'parent_id' => '2', 'keywords' => 'Hankook', 'description' => 'Hankook'],
            ['id' => '6', 'title' => 'Белшина','alias' => 'belshina', 'parent_id' => '2', 'keywords' => 'Белшина', 'description' => 'Belshina'],
            ['id' => '7', 'title' => 'Kumho','alias' => 'kumho', 'parent_id' => '2', 'keywords' => 'Kumho', 'description' => 'Kumho'],
            ['id' => '8', 'title' => 'Viatti','alias' => 'viatti', 'parent_id' => '2', 'keywords' => 'Viatti', 'description' => 'Viatti'],
            ['id' => '9', 'title' => 'BFGoodrich','alias' => 'bfgoodrich', 'parent_id' => '3', 'keywords' => 'BFGoodrich', 'description' => 'BFGoodrich'],
            ['id' => '10', 'title' => 'Goodyear','alias' => 'goodyear', 'parent_id' => '3', 'keywords' => 'Goodyear', 'description' => 'Goodyear'],
            ['id' => '11', 'title' => 'Michelin','alias' => 'michelin', 'parent_id' => '3', 'keywords' => 'Michelin', 'description' => 'Michelin'],
            ['id' => '12', 'title' => 'Barum','alias' => 'barum', 'parent_id' => '3', 'keywords' => 'Barum', 'description' => 'Barum'],
            ['id' => '13', 'title' => 'Continental','alias' => 'continental', 'parent_id' => '4', 'keywords' => 'Continental', 'description' => 'Continental'],
            ['id' => '14', 'title' => 'KAMA','alias' => 'kama', 'parent_id' => '4', 'keywords' => 'KAMA', 'description' => 'KAMA'],
            ['id' => '15', 'title' => 'Kormoran','alias' => 'kormoran', 'parent_id' => '4', 'keywords' => 'kormoran', 'description' => 'Kormoran'],
            ['id' => '16', 'title' => 'Lassa','alias' => 'lassa', 'parent_id' => '4', 'keywords' => 'lassa', 'description' => 'Hankook'],
        ];

        DB::table('categories')->insert($data);
    }
}
