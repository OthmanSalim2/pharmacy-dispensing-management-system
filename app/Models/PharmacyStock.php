<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacyStock extends Model
{
    public $table = 'pharmacy_stocks';

    protected $fillable = [
        'name', 'code', 'quantity', 'active_ingredient', 'unit_type',
        'price', 'expiration_date', 'treatment_type', 'shipping_price',
        'pharmacy_price', 'patient_price', 'date', 'pills_per_strip',
        'strips_per_box'
    ];

    public $casts = [
        'expiration_date' => 'datetime',
        'date' => 'datetime',
    ];

    public function rohta(): BelongsTo
    {
        return $this->belongsTo(RohtaMedicine::class, 'medicine_code', 'id');
    }
}
