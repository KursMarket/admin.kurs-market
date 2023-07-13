<?php

namespace App\Enums\Reviews;

class Sources
{
    const YANDEX_MAP = 'yandex_map';
    const GOOGLE_MAP = 'google_map';
    const OTZOVIK = 'otzovik';
    const IRECOMMEND = 'irecommend';
    const ZOON = 'zoon';
    const KURS_MARKET = 'kurs_market';

    public static function getReviewSources(): array
    {
        return [
            self::YANDEX_MAP,
            self::GOOGLE_MAP,
            self::OTZOVIK,
            self::IRECOMMEND,
            self::ZOON,
            self::KURS_MARKET,
        ];
    }

    public function getAllReviewSources(): array
    {
        return [
            ['id' => self::YANDEX_MAP, 'text' => 'Яндекс карты'],
            ['id' => self::GOOGLE_MAP, 'text' => 'Google карты'],
            ['id' => self::OTZOVIK, 'text' => 'Отзовик'],
            ['id' => self::IRECOMMEND, 'text' => 'iRecommend'],
            ['id' => self::ZOON, 'text' => 'Zoon'],
            ['id' => self::KURS_MARKET, 'text' => 'Курс маркет'],
        ];
    }
}
