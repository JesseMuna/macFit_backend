<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //fillable is a variable laravel expects
    //it contains a list of user inputs
    protected $fillable = [
        'name',
        'description'
    ];
}
