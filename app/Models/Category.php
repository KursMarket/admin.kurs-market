<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'meta_h1',
        'sort_order',
        'type_id',
        'parent_id',
        'show_in_catalog',
        'show_in_rating',
        'meta_title',
        'meta_description',
        'text_before_courses_list',
        'text_after_courses_list',
        'url',
    ];

    public function type(): HasOne
    {
        return $this->hasOne(CatalogType::class, 'id', 'type_id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function relatedCategories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_related',
            'category_id',
            'related_category_id'
        );
    }
}
