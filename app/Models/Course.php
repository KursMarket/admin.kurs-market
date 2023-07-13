<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const ACTIVE_STATUS = 'active';
    const MODERATION_STATUS = 'moderation';
    const REJECTED_STATUS = 'rejected';
    const HIDDEN_STATUS = 'hidden';

    protected $fillable = [
        'school_id',
    ];

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'user_id', 'school_id');
    }

    public function duration(): HasOne
    {
        return $this->hasOne(StudyDuration::class, 'id', 'study_duration_key');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_course',
            'course_id',
            'category_id'
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'tag_course',
            'course_id',
            'tag_id'
        );
    }

    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this->addMediaConversion('course-preview')
                ->fit(Manipulations::FIT_CROP, 438, 250)
                ->nonQueued();
        } catch (InvalidManipulation $e) {
            Log::error("Media for courses: {$e->getMessage()}, {$e->getFile()}");
        }
    }
}
