<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    public $table = 'pharmacies';

    protected $fillable = [
        'treatment_name', 'treatment_code', 'active_ingredient', 'rest_of_it', 'required_quantity', 'note',
    ];
}
