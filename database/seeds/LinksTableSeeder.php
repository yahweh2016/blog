<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
            'link_name'  => '新浪动漫',
            'link_title' => '新浪动漫链接',
            'link_url'   => 'http://comic.sina.com.cn/',
            'link_order' => '1'
            ],
            [
                'link_name'  => '新浪动漫2',
                'link_title' => '新浪动漫链接2',
                'link_url'   => 'http://comic.sina.com.cn/',
                'link_order' => '2'
            ]
        ];
        DB::table('links')->insert($data);
    }
}
