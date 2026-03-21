<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    protected $fillable = [
        'name',
        'city_name',
        'region',
        'stage_number',
        'is_boss_stage',
        'map_pin_x',
        'map_pin_y',
    ];

    protected $casts = [
        'is_boss_stage' => 'boolean',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}

