<?php

use Illuminate\Database\Seeder;

class AttributeGroupsSeeder extends Seeder
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
                'title' => 'Сезон',
                'category_id' => '1',
            ],
            [
                'id' => '2',
                'title' => 'Назначение',
                'category_id' => '1',
            ],
            [
                'id' => '3',
                'title' => 'Ширина профиля',
                'category_id' => '1',
            ],
            [
                'id' => '4',
                'title' => 'Серия(высота профиля)',
                'category_id' => '1',
            ],
            [
                'id' => '5',
                'title' => 'Посадочный диаметр',
                'category_id' => '1',
            ],

        ];
        DB::table('attribute_groups')->insert($data);
    }
}
