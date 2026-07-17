<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'category',
        'has_option',
        'is_available',
        'shop_id',
        'stock_status'
    ];

    public function options()
    {
        return $this->hasMany(
            ProductOption::class
        );
    }
}