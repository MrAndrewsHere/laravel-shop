<?php

namespace App\Models;


use App\Actions\FilterProductExtra;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Product extends \App\Domain\Product\Product
{
    public function extras(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ExtraValue::class)->with('extra');
    }

    public function scopeFilterProductExtra(Builder $query, array|Collection $filters = null): Builder
    {
        return (new FilterProductExtra())($query,$filters);
    }
}
