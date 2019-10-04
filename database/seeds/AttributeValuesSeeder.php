<?php

use Illuminate\Database\Seeder;

class AttributeValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1', 'value' => 'Летние', 'attr_group_id' => '1'],
            ['id' => '2', 'value' => 'Зимние', 'attr_group_id' => '1'],
            ['id' => '3', 'value' => 'Всесезонные', 'attr_group_id' => '1'],
            ['id' => '4', 'value' => 'Для внедорожников', 'attr_group_id' => '2'],
            ['id' => '5', 'value' => 'Для легковых автомобилей', 'attr_group_id' => '2'],
            ['id' => '6', 'value' => 'Для микроавтобусов и легкогрузовых автомобилей', 'attr_group_id' => '2'],
            ['id' => '7', 'value' => 'Для автобусов и грузовых автомобилей', 'attr_group_id' => '2'],
            ['id' => '8', 'value' => '114 мм', 'attr_group_id' => '3'],
            ['id' => '9', 'value' => '125 мм', 'attr_group_id' => '3'],
            ['id' => '10', 'value' => '135 мм', 'attr_group_id' => '3'],
            ['id' => '11', 'value' => '145 мм', 'attr_group_id' => '3'],
            ['id' => '12', 'value' => '35', 'attr_group_id' => '4'],
            ['id' => '13', 'value' => '40', 'attr_group_id' => '4'],
            ['id' => '14', 'value' => '45', 'attr_group_id' => '4'],
            ['id' => '15', 'value' => '50', 'attr_group_id' => '4'],
            ['id' => '16', 'value' => '55', 'attr_group_id' => '4'],
            ['id' => '17', 'value' => '65', 'attr_group_id' => '4'],
            ['id' => '18', 'value' => '15"', 'attr_group_id' => '5'],
            ['id' => '19', 'value' => '16"', 'attr_group_id' => '5'],


        ];
        DB::table('attribute_values')->insert($data);
    }
}
