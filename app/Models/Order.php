<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'table_id',
        'name',
        'price',
        'quantity',
        'taste',
        'seat',
        'served_quantity',
    ];
}