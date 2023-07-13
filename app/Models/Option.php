<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Option extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const MAIN_BANNER_H1_TITLE = 'main_banner_h1_title';
    const MAIN_BANNER_IMAGE = 'main_banner_image';
    const ADVANTAGES_BLOCK = 'advantages_block';
    const QUIZ_MODULE = 'quiz_module';
    const PROMO_MODULE = 'promo_module';
    const COLLABORATION_MODULE = 'collaboration_module';

    protected $fillable = ['option_name', 'option_value'];
    public $timestamps = false;

    private string $conversionPrefix;

    public function __construct(array $attributes = [], string $conversionPrefix = "")
    {
        parent::__construct($attributes);
        $this->conversionPrefix = "{$conversionPrefix}_options";
    }

    public function setConversionPrefix(string $str) {
        $this->conversionPrefix = "{$str}_options";
    }

    public function getConversionPrefix(): string
    {
        return $this->conversionPrefix;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this
                ->addMediaConversion($this->getConversionPrefix())
                ->fit(Manipulations::FIT_CROP, 140, 30)
                ->nonQueued();
        } catch (InvalidManipulation $e) {
            Log::error("Media for schools: {$e->getMessage()}, {$e->getFile()}");
            dd($e->getMessage());
        }
    }
}
