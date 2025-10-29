<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    public $table = 'prescriptions';

    protected $fillable = [
        'name', 'price', 'categories'
    ];
}
