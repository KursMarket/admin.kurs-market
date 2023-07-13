<?php


namespace App\Dto;


use App\Models\StudyDuration;
use Spatie\DataTransferObject\DataTransferObject;

class StudyDurationDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public string $alias;
    public int $sort_order;

    public static function toDto(StudyDuration $duration): self
    {
        return new static([
            'id' => $duration->id,
            'title' => $duration->title,
            'alias' => $duration->alias,
            'sort_order' => intval($duration->sort_order),
        ]);
    }
}
