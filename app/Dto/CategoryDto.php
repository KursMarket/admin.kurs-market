<?php


namespace App\Dto;


use App\Models\Category;
use App\Services\CategoryServiceImpl;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

final class CategoryDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public string $url;
    public ?int $total;
    public array|Collection $children = [];

    public static function toDto(Category $category, CategoryServiceImpl $service): self
    {
        return new static([
            'id' => $category['id'],
            'title' => $category['title'],
            'url' => $category['url'],
            'total' => 5,
            'children' => $service->get($category['id'])
        ]);
    }

    public static function toSelectDto(Category $category): self
    {
        return new static([
            'id' => $category['id'],
            'title' => $category['title'],
            'url' => $category['url'],
        ]);
    }
}
