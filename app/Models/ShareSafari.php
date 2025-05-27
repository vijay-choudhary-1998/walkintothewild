<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareSafari extends Model
{
    protected $fillable = [
        'title',
        'park_id',
        'start_date',
        'end_date',
        'no_of_safari',
        'theme',
        'stay_categroy',
        'min_price_pp',
        'max_price_pp',
        'total_seats',
        'share_seats',
        'display_image',
        'picture',
        'safari_plan',
    ];

    public function park()
    {
        return $this->belongsTo(Park::class);
    }
}
