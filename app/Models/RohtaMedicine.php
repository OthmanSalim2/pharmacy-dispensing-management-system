<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RohtaMedicine extends Model
{
    protected $table = 'rohta_medicines';

    protected $fillable = [
        'user_id',
        'patient_name',
        'unit_type',
        'medicine_code',
        'quantity',
        'unit_price',
        'total',
        'status',
        'is_exempt',
        'exemption_reason'
    ];

    // Relation to PharmacyStock
    public function medicine(): BelongsTo
    {
        // 'medicine_code' in RohtaMedicine points to 'id' in PharmacyStock
        return $this->belongsTo(PharmacyStock::class, 'medicine_code', 'id');
    }

    // Relation to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
