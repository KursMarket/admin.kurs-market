<?php


namespace App\Dto;


use App\Models\CatalogType;
use App\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryEditDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public ?string $meta_h1;
    public ?int $sort_order;
    public ?CatalogType $type;
    public ?Category $parent;
    public bool $show_in_catalog;
    public bool $show_in_rating;
    public ?string $meta_title;
    public ?string $meta_description;
    public ?string $text_before_courses_list;
    public ?string $text_after_courses_list;
    public ?string $url;
    public array $relatedCategories = [];

    public static function toDto(Category $category): self
    {
        $relatedCategories = [];
        $related = $category->relatedCategories;

        if ($related->isNotEmpty()) {
            foreach ($related as $item) {
                $relatedCategories[] = $item;
            }
        }
        return new static([
            'id'                        => $category->id,
            'title'                     => $category->title,
            'meta_h1'                   => $category->meta_h1,
            'sort_order'                => $category->sort_order,
            'type'                      => $category->type,
            'parent'                    => $category->parent,
            'show_in_catalog'           => boolval($category->show_in_catalog),
            'show_in_rating'            => boolval($category->show_in_rating),
            'meta_title'                => $category->meta_title,
            'meta_description'          => $category->meta_description,
            'text_before_courses_list'  => $category->text_before_courses_list,
            'text_after_courses_list'   => $category->text_after_courses_list,
            'url'                       => $category->url,
            'relatedCategories'         => $relatedCategories
        ]);
    }
}
