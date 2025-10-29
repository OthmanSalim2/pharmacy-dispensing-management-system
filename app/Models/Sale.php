<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'quantity',
        'unit_type',
        'price',
        'total',
        'date',
        'shipping_price',
        'note',
        'user_id',
    ];
}
