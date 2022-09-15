<?php

namespace Database\Seeders;

use App\Enums\ExtraEnum;
use App\Models\Product;
use App\Models\Extra;
use App\Models\ExtraValue;
use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(int $products_count = 50000,int $cities_count = 30, int $categories_count = 100)
    {

        $exists = Product::count();
        if ($exists < $products_count) {
            Product::factory($products_count - $exists)->create();
        }
        $products = Product::all();
        $city_extra = Extra::query()->firstOrCreate(['name' => ExtraEnum::city->name]);
        $category_extra = Extra::query()->firstOrCreate(['name' => ExtraEnum::category->name]);

        if (ExtraValue::count() == 0) {
            $city_extra->extras()->saveMany(ExtraValue::factory($cities_count)->make());
            $category_extra->extras()->saveMany(ExtraValue::factory($categories_count)->make());
        }

        $cities = ExtraValue::extraOnly($city_extra)->get();
        $categories = ExtraValue::extraOnly($category_extra)->get();



        $products->filter(fn($i) => !$i->extras()->exists())
            ->each(fn($product) => $product->extras()->saveMany($categories->random(1)->concat($cities->random(1))));
    }
}
