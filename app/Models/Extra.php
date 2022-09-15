<?php

namespace App\Models;

use App\Enums\ExtraEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{

    protected $table = "extras";

    protected $fillable = ['name'];

    public function extraValue(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExtraValue::class, 'extra_id', 'id');
    }

    public function scopeName(Builder $builder, ExtraEnum $name): Builder
    {
        return $builder->where('name', '=', $name->value);
    }
}
