<?php

namespace App\Models\utils;

use App\Models\ExtraValue;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FilterProductExtra
{

    protected Builder $query;
    protected array $filteredKeys = array();

    public function __invoke(Builder $query, array|Collection $filter): Builder
    {

        if (count($filter) == 0) {
            return $query;
        }
        $this->query = $query;

        foreach ($filter as $item) {
            if (method_exists($this, $item->key)) {
                extract($item->toArray());
                $this->$key(
                    $key,$value
                );
            }
        }
        return $this->query;
    }

    protected function category(): void
    {
        if (!in_array('category', $this->filteredKeys)) {
            $this->apply(...func_get_args());
        }
    }

    protected function city(): void
    {
        if (in_array('city', $this->filteredKeys)) {
            $this->apply(...array_merge(func_get_args(), ['method' => 'orWhereHas']));
        } else {
            $this->apply(...func_get_args());
        }
    }

    protected function apply(string $key, string|ExtraValue $value, string $method = 'whereHas'): void
    {

        $this->filteredKeys[] = $key;
        $extra = is_string($value) ? ExtraValue::extraOnly($key)->where('value', '=', $value)->first() : $value;

        $this->query->$method('extras', function (Builder $query) use ($extra) {
            return $query->where('extra_value_id', '=', $extra?->id ?? null);
        });

    }
}
