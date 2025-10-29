<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public $table = 'orders';

    protected $fillable = [
        'name', 'code', 'active_ingredient', 'unit_type', 'price',
        'rest_of_it', 'required_quantity', 'status', 'note', 'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacyStock(): BelongsTo
    {
        return $this->belongsTo(PharmacyStock::class, 'code', 'code');
    }

}
