<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $table = 'stores';

    protected $fillable = [
        'name', 'code', 'quantity', 'active_ingredient', 'unit_type',
        'price', 'expiration_date', 'shipping_price',
        'type_of_medication', 'pharmacy_price', 'patient_price', 'date',
        'note', 'pills_per_strip', 'strips_per_box',
    ];

    public $casts = [
        'expiration_date' => 'datetime',
    ];
}
