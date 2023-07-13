<?php

namespace App\Enums\Reviews;

class Status
{
    const MODERATION = 'moderation';
    const REJECTED = 'rejected';
    const PUBLISHED = 'published';

    public static function getReviewStatuses(): array
    {
        return [
            self::MODERATION,
            self::REJECTED,
            self::PUBLISHED,
        ];
    }

    public function getAllReviewStatuses(): array
    {
        return [
            ['id' => self::MODERATION, 'text' => 'На модерации'],
            ['id' => self::REJECTED, 'text' => 'Отклонен'],
            ['id' => self::PUBLISHED, 'text' => 'Опубликован'],
        ];
    }

    public function getAllReviewStatusesWithColor(): array
    {
        return [
            ['text'=> self::PUBLISHED, 'color' => '#9DC892'],
            ['text'=> self::MODERATION, 'color' => '#F3E4AB'],
            ['text'=> self::REJECTED, 'color' => '#D75D5D'],
        ];
    }
}
