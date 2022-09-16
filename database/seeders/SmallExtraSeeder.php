<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SmallExtraSeeder extends Seeder
{

    public function run()
    {
        $products_count = 300;
        $cities_count = 30;
        $categories_count = 100;
        $this->call(ExtraSeeder::class,false,['products_count' => $products_count,'cities_count' =>$cities_count, 'categories_count' => $categories_count]);
    }
}
