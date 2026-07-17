<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'product_id',
        'option_name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}