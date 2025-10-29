<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public $table = 'medicines';

    protected $fillable = [
        'name', 'price', 'code', 'quantity', 'category', 'number_of_units', 'type'
    ];
}
