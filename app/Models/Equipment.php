<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'usage',
        'model_no',
        'status',
        'value',

    ];
}
