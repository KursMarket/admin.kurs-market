<?php


namespace App\Dto;


use App\Models\Tag;
use Spatie\DataTransferObject\DataTransferObject;

class TagDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public string $alias;
    public int $sort_order;

    public static function toDto(Tag $tag): self
    {
        return new static([
            'id' => $tag->id,
            'title' => $tag->title,
            'alias' => $tag->alias,
            'sort_order' => intval($tag->sort_order),
        ]);
    }
}
