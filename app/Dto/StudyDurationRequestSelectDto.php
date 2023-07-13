<?php


namespace App\Dto;


use App\Models\StudyDuration;
use Spatie\DataTransferObject\DataTransferObject;

class StudyDurationRequestSelectDto extends DataTransferObject
{
    public int $id;
    public string $text;

    public static function toSelectionDto(StudyDuration $duration): self
    {
        return new static([
            'id' => $duration->id,
            'text' => $duration->title
        ]);
    }
}
