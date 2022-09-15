@php
/** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Domain\Product\Product[] $products */
@endphp

<x-app-layout title="Products">
    <div class="mb-4">
        <h2 class="mb-4">Filters</h2>
        <form action="/" method="get">
            <div>
                <h2>Categories</h2>
                <select name="category" class="form-control mb-4">
                    <option></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->value }}">{{ $category->value }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h2>City</h2>
                <select name="city" class="form-control mb-4">
                    <option></option>
                    @foreach($cities as $city)
                        <option value="{{ $city->value}}">{{ $city->value }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>
    </div>

    <div class="grid grid-cols-3 gap-12">
        @foreach($products as $product)
            <x-product
                :title="$product->name"
                :price="format_money($product->getItemPrice()->pricePerItemIncludingVat())"
                :extras="$product->extras"
                :actionUrl="action(\App\Http\Controllers\Cart\AddCartItemController::class, [$product])"
          />
        @endforeach
    </div>

    <div class="mx-auto mt-12">
        {{ $products->withQueryString()->links() }}
    </div>
</x-app-layout>
