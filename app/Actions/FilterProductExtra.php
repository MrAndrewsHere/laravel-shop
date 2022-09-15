<?php

namespace App\Actions;

use App\Enums\ExtraEnum;
use App\Models\ExtraValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FilterProductExtra
{

    protected array $filtered = array();
    protected Builder $query;

    public function __invoke(Builder $query, array|Collection $filter): Builder
    {

        if (count($filter) == 0) {
            return $query;
        }
        $this->query = $query;
        if ($filter instanceof Collection) {
            $filter = $filter->map(fn($i) => [$i['field'] => $i['value']])->toArray();
        }

        foreach ($filter as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($key, $value);
            }
        }
        return $this->query;
    }

    protected function category(): void
    {
        if (in_array('category', $this->filtered)) {
            return;
        }
        $this->apply(...func_get_args());

    }

    protected function city(): void
    {
        if (in_array('city', $this->filtered)) {
            $this->apply(...func_get_args() + ['method' => 'orWhere']);
            return;
        }
        $this->apply(...func_get_args());
    }

    protected function apply(string $key, string|ExtraValue $value, string $method = 'where'): void
    {
        $extra = is_string($value) ? ExtraValue::extraOnly($key)->where('value', '=', $value)->first() : $value;

        $this->query->whereHas('extras', function (Builder $query) use ($extra, $method) {
            return $query->$method('extra_value_id', '=', $extra?->id ?? null);
        });
        $this->filtered[] = $key;
    }
}
