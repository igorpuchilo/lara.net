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
            ],
            [
                'id' => '2',
                'title' => 'Назначение',
            ],
            [
                'id' => '3',
                'title' => 'Ширина профиля',
            ],
            [
                'id' => '4',
                'title' => 'Серия(высота профиля)',
            ],
            [
                'id' => '5',
                'title' => 'Посадочный диаметр',
            ],

        ];
        DB::table('attribute_groups')->insert($data);
    }
}
