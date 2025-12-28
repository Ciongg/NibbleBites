<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'ingredients',
        'instructions',
        'image_path',
        'difficulty',
        'cost_range',
        'minutes_to_make',
        'servings',
        'calories_per_serving',
        'is_private',
        'is_vegan',
        'nibbled_count',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'is_private' => 'boolean',
        'is_vegan' => 'boolean',
        'minutes_to_make' => 'integer',
        'servings' => 'integer',
        'calories_per_serving' => 'integer',
        'nibbled_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
