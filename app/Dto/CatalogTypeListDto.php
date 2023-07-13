<?php


namespace App\Dto;


use App\Models\CatalogType;
use Spatie\DataTransferObject\DataTransferObject;

class CatalogTypeListDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public string $url;
    public int $sort_order;

    public static function toDto(CatalogType $catalogType): self
    {
        return new static([
            'id' => $catalogType->id,
            'title' => $catalogType->title,
            'url' => $catalogType->url,
            'sort_order' => $catalogType->sort_order,
        ]);
    }
}
