<?php

namespace App\Dto;

use App\Models\Course;
use App\Models\School;
use Spatie\DataTransferObject\DataTransferObject;

class CourseSchoolResultForFilters extends DataTransferObject
{
    public int $id;
    public string $text;
    public ?int $school_id;
    public ?int $user_id;

    public static function toDto(School $school): self
    {
        return new static([
            'id' => $school->user_id,
            'text' => $school->name,
        ]);
    }

    public static function toDtoWithCorrectId(School $school): self
    {
        return new static([
            'id' => $school->id,
            'text' => $school->name,
        ]);
    }

    public static function toListDtoForFiltering(Course $course): self
    {
        return new static([
            'id' => $course->id,
            'text' => $course->title,
            'school_id' => $course->school_id,
        ]);
    }
}
