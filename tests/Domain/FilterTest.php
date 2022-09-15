<?php

namespace Tests\Domain;

use App\Enums\ExtraEnum;
use App\Models\ExtraValue;
use App\Models\Product;
use Database\Seeders\SmallExtraSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function test_example()
    {
        $this->seed(SmallExtraSeeder::class);

        $categories = ExtraValue::extraOnly(ExtraEnum::category)->get();
        $category1 = $categories->first();
        $category2 = $categories->last();

        $select1 = $this->select([
            ExtraEnum::category->name => $category1->name()
        ]);
        $select2 = $this->select([
            ExtraEnum::category->name => $category1->name(),
            ExtraEnum::category->name => $category2->name(),
        ]);

        $this->assertTrue($select1 === $select2); // Только одна категория

        $cities = ExtraValue::extraOnly(ExtraEnum::city)->get();
        $city1 = $cities->first();
        $city2 = $cities->last();
        $city3 = $cities->random(1)[0];

        $select3 = $this->select([
            ExtraEnum::city->name => $city1->name()
        ]);
        $select4 = $this->select([
            ExtraEnum::city->name => $city2->name(),
            ExtraEnum::city->name => $city2->name(),
            ExtraEnum::city->name => $city3->name(),
        ]);

        $this->assertTrue($select4 != $select3); // Один или несколько городов

        $select5 = $this->select([
            ExtraEnum::category->name => $category1->name(),
            ExtraEnum::city->name => $city1->name(),
        ]);

        $this->assertTrue($select5 === ($select1 + $select3)); // И город и категория
    }

    public function select(array $f)
    {
        return Product::query()->FilterProductExtra($f)->get()->count();
    }
}
