<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'table';

    protected $primaryKey = 'table_id';

    protected $fillable = [
        'store_id',
        'table_number',
        'seat_status',
        'max_people'
    ];
}
