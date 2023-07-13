<?php


namespace App\Dto;


use App\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class CategorySchoolForFilterDto extends DataTransferObject
{
    public int $id;
    public string $text;

    public static function toDto(Category $category): self
    {
        return new static([
            'id' => $category->id,
            'text' => $category->title,
        ]);
    }
}
