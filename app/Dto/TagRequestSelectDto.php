<?php


namespace App\Dto;


use App\Models\Tag;
use Spatie\DataTransferObject\DataTransferObject;

class TagRequestSelectDto extends DataTransferObject
{
    public int $id;
    public string $text;

    public static function toSelectDto(Tag $tag): self
    {
        return new static([
            'id' => $tag->id,
            'text' => $tag->title
        ]);
    }
}
