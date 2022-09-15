<?php

namespace App\Http\Controllers\Products;


use App\Enums\ExtraEnum;
use App\Http\Controllers\Controller;
use App\Models\ExtraValue;
use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke()
    {
        $data = $this->validate(request(), [
            'city' => ['string', 'nullable'],
            'category' => ['string', 'nullable'],
        ]);
        $data = array_filter($data, fn($i) => !!$i);
        $products = Product::query()->with('extras')->FilterProductExtra($data)->paginate();
        $cities = ExtraValue::extraOnly(ExtraEnum::city)->get();
        $categories = ExtraValue::extraOnly(ExtraEnum::category)->get();
        return view('products.index', ['products' => $products, 'cities' => $cities, 'categories' => $categories]);
    }
}
