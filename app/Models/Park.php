<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Park extends Model
{
    use HasFactory;
       protected $fillable = [
        'title', 'slug', 'short_description', 'description', 'city',
        'state', 'country', 'train', 'airport', 'safari_session',
        'wildlife_found', 'safari_cost', 'safari_mode', 'closed_months'
    ];
}
