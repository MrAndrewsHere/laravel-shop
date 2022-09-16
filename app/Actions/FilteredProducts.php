<?php

namespace App\Actions;

use App\DTO\ExtraFilterDTO;
use App\Enums\ExtraEnum;
use App\Models\ExtraValue;
use App\Models\Product;

class FilteredProducts
{
    public function __invoke(array $data)
    {
        $data = collect($data)->filter( fn($i) => !!$i)->map(fn($i,$k) => new ExtraFilterDTO($k,$i));
        $products = Product::query()->with('extras')->FilterProductExtra($data)->paginate();
        $cities = ExtraValue::extraOnly(ExtraEnum::city)->get();
        $categories = ExtraValue::extraOnly(ExtraEnum::category)->get();
        return ['products' => $products, 'cities' => $cities, 'categories' => $categories];
    }
}
