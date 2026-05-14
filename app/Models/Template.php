<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;

class Template extends Model
{
    use HasFactory, HasTags;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'type',
        'description',
        'short_description',
        'price',
        'thumbnail',
        'secure_file_path',
        'preview_url',
        'meta_data',
        'is_active',
        'author_id',
        'color_space',
        'orientation',
        'properties',
        'compatible_tools',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'properties' => 'array',
        'compatible_tools' => 'array',
        'thumbnail' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Check if template is free
     */
    public function isFree(): bool
    {
        return !$this->price || $this->price <= 0;
    }

    /**
     * Get main thumbnail (first in array)
     */
    public function getMainThumbnailAttribute(): ?string
    {
        if (is_array($this->thumbnail) && count($this->thumbnail) > 0) {
            return $this->thumbnail[0];
        }
        return is_string($this->thumbnail) ? $this->thumbnail : null;
    }

    /**
     * Many-to-many categories (pivot table)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_template');
    }

    /**
     * Legacy single category (kept for backward compat)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
