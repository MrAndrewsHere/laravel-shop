<?php

namespace App\Http\Controllers\Products;

use App\Actions\FilteredProducts;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    public function __invoke()
    {
        $data = $this->validate(request(), [
            'city' => ['string', 'nullable'],
            'category' => ['string', 'nullable'],
        ]);
        return view('products.index', (new FilteredProducts())($data));
    }
}
