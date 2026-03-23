<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $fillable = [
        'stage_id',
        'name',
    ];

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}

