<?php

use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
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
                'title' => 'Hankook',
                'alias' => 'hankook',
                'img' => 'abt-1.jpg',
                'description' => 'In sit amet sapien eros Integer dolore magna aliqua'
            ],
            [
                'id' => '2',
                'title' => 'Goodyear',
                'alias' => 'goodyear',
                'img' => 'abt-2.jpg',
                'description' => 'In sit amet sapien eros Integer dolore magna aliqua'
            ],
            [
                'id' => '3',
                'title' => 'Tigar',
                'alias' => 'tigar',
                'img' => 'abt-3.jpg',
                'description' => 'In sit amet sapien eros Integer dolore magna aliqua'
            ],
            [
                'id' => '4',
                'title' => 'Белшина',
                'alias' => 'seiko',
                'img' => 'seiko.png',
                'description' => 'In sit amet sapien eros Integer dolore magna aliqua'
            ],
            [
                'id' => '5',
                'title' => 'Pirelli',
                'alias' => 'pirelli',
                'img' => 'diesel.png',
                'description' => 'In sit amet sapien eros Integer dolore magna aliqua'
            ],

        ];

        DB::table('brands')->insert($data);
    }
}
