<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareSafari extends Model
{
    protected $fillable = [
        'title',
        'safari_park_id',
        'start_date',
        'end_date',
        'no_of_safari',
        'visit_purpose_id',
        'stay_category_id',
        'min_price_pp',
        'max_price_pp',
        'total_seats',
        'share_seats',
        'safari_plan',
        'display_image',
    ];

    public function park()
    {
        return $this->belongsTo(Park::class);
    }
}
