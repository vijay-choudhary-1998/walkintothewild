<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wildlife extends Model
{
     use HasFactory;

    protected $fillable = [
        'name', 'species', 'habitat', 'description'
    ];
}
