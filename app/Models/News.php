<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    const ARTICLE = 'ARTICLE';
    const NEWS = 'NEWS';

    const ACCESS_LEVEL_STUDENT = 'student';
    const ACCESS_LEVEL_SCHOOL = 'school';
    const ACCESS_LEVEL_ALL = 'all';
    const ACCESS_LEVEL_UNAUTHORIZED = 'unauthorized';

    const MEDIA_KEY = 'news-media';
    const MEDIA_KEY_VIDEO = 'news-media-video';

    protected $fillable = [
        'title',
        'type_id',
        'text',
        'url',
        'link',
        'visible_for',
        'section',
        'views',
        'meta_h1',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public static function getTypes() {
        return [
            self::NEWS => 'Новость',
            self::ARTICLE => 'Статья',
        ];
    }

    public static function getArticlesLevels() {
        return [

            self::ACCESS_LEVEL_ALL => 'Все',
            self::ACCESS_LEVEL_UNAUTHORIZED => 'Неавторизованные',
            self::ACCESS_LEVEL_STUDENT => 'Ученики',
            self::ACCESS_LEVEL_SCHOOL => 'Школы',

        ];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_KEY);
    }
}
