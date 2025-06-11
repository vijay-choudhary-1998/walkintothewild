<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = false;

    public static function getValue($key, $default = '')
    {
        return static::where('key', $key)->value('value') ?? $default;
    }
}
