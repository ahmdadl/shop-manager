<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'total' => 'double',
        'amount' => 'int',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function scopeSell(Builder $builder): Builder
    {
        return $builder->where('type', 'sell');
    }

    public function scopeBuy(Builder $builder): Builder
    {
        return $builder->where('type', 'buy');
    }

    public function scopeOfType(Builder $builder, string $type): Builder
    {
        return $builder->where('type', $type);
    }
}
