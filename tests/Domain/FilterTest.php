<?php

namespace Tests\Domain;

use App\DTO\ExtraFilterDTO;
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
     * @test
     * @return void
     */
    public function test_extra_filter()
    {
        $this->seed(SmallExtraSeeder::class);


        $categories = ExtraValue::extraOnly(ExtraEnum::category)->get();
        $category1 = $categories->first();
        $category2 = $categories->last();


        $select1 = $this->select([
            new ExtraFilterDTO(ExtraEnum::category->name,$category1->value)
        ]);

        $select2 = $this->select([
            new ExtraFilterDTO(ExtraEnum::category->name,$category1->value),
            new ExtraFilterDTO(ExtraEnum::category->name,$category2->value)
        ]);

        $this->assertTrue($select1 === $select2);

        $cities = ExtraValue::extraOnly(ExtraEnum::city)->get();
        $city1 = $cities->first();
        $city2 = $cities->last();
        $city3 = $cities->random(1)[0];


        $select3 = $this->select([
            new ExtraFilterDTO(ExtraEnum::city->name,$city1->value)
        ]);
        $select4 = $this->select([
            new ExtraFilterDTO(ExtraEnum::city->name,$city1->value),
            new ExtraFilterDTO(ExtraEnum::city->name,$city2->value),
            new ExtraFilterDTO(ExtraEnum::city->name,$city3->value)
        ]);

        $this->assertTrue($select4 > $select3);

    }

    public function select(array $array):int
    {
        return Product::query()->filterProductExtra($array)->count();
    }
}
