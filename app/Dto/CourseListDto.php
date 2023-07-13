<?php

namespace App\Dto;

use App\Models\Course;
use App\Models\School;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class CourseListDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public School $school;
    public ?string $status;
    public string $createdAt;
    public string $price;

    public static function toListDto(Course $course): self
    {
        return new static([
            'id' => $course->id,
            'title' => $course->title,
            'school' => $course->school,
            'status' => "<span style='display:flex;align-items: center;'><span style='display: inline-block;width: 10px;height: 10px;background-color: ". self::getColorFromStatus($course->status) .";margin-right:5px;'></span><span>". self::getStatusName($course->status) ."</span></span>",
            'createdAt' => Carbon::parse($course->created_at)->format('d.m.Y'),
            'price' => $course->price
        ]);
    }

    private static function getColorFromStatus($status): string
    {
        return match ($status) {
            Course::REJECTED_STATUS => '#D75D5D',
            Course::MODERATION_STATUS => '#F3E4AB',
            Course::HIDDEN_STATUS => 'rgba(215, 93, 93, 0.4)',
            default => '#9DC892',
        };
    }

    private static function getStatusName($status): string
    {
        return match ($status) {
            Course::REJECTED_STATUS => 'Отклонен',
            Course::MODERATION_STATUS => 'На модерации',
            Course::HIDDEN_STATUS => 'Скрыт',
            default => 'Активный',
        };
    }
}
