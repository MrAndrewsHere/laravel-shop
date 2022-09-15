<?php

namespace App\Models;

use App\Domain\Product\Product;
use App\Enums\ExtraEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraValue extends Model
{
    use HasFactory;

    protected $table = "extra_values";

    protected $fillable = ['extra_id', 'value'];

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products');
    }

    public function extra(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Extra::class, 'id', 'extra_id');
    }

    public function name(){
        return $this->extra->name;
    }
    public function scopeExtraOnly(Builder $query, string|Extra|ExtraEnum $extra): Builder
    {
        $extra = $extra instanceof Extra ? $extra
            : Extra::name($extra instanceof ExtraEnum ? $extra : ExtraEnum::tryFrom($extra))
                ->first();
        return $query->where('extra_id', '=', $extra?->id ?? null);
    }
}
