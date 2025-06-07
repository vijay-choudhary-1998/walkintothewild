<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSlug;

class Park extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'city_id',
        'state_id',
        'country_id',
        'train',
        'airport',
        'safari_session',
        'wildlife_found',
        'safari_cost',
        'safari_mode',
        'closed_months'
    ];

    protected function getSlugSourceField()
    {
        return 'title';
    }

    protected function getSlugField()
    {
        return 'slug';
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function wildlife()
    {
        return $this->belongsTo(Wildlife::class,'wildlife_found');
    }
}
