<?php


namespace App\Dto;


use App\Models\Category;
use App\Models\Course;
use App\Models\School;
use App\Models\StudyDuration;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class CourseSingleDto extends DataTransferObject
{
    public int $id;
    public string $title;
    public string $prefix;
    public School $school;
    public ?string $source_link;
    public ?Category $category;
    public ?Collection $sub_categories;
    public bool $show_in_rating;
    public ?int $study_duration;
    public ?StudyDuration $study_duration_key;
    public ?Collection $tags;
    public float $price;
    public bool $credit;
    public null|int|string $credit_month;
    public null|int|string $credit_month_price;
    public bool $sale;
    public ?string $sale_key;
    public ?string $sale_price;
    public ?string $additional_description;
    public null|int|string $feed_id;
    public int $sort_order_in_schools;
    public int $sort_order_in_categories;
    public string $url;
    public ?string $image;

    public static function toDto(Course $course): self
    {
        $categories = $course->categories;
        return new static([
            'id' => $course->id,
            'title' => $course->title,
            'prefix' => $course->prefix,
            'school' => $course->school,
            'source_link' => $course->source_link,
            'category' => $categories?->first()?->parent,
            'sub_categories' => $categories?->map(fn(Category $category): array => ['id' => $category->id, 'text' => $category->title]),
            'show_in_rating' => (bool)$course->show_in_rating,
            'study_duration' => $course->study_duration,
            'study_duration_key' => $course->duration,
            'tags' => $course->tags?->map(fn(Tag $tag): array => ['id' => $tag->id, 'text' => $tag->title]),
            'price' => $course->price,
            'credit' => $course->credit_price && $course->credit_month,
            'credit_month' => $course->credit_month,
            'credit_month_price' => $course->credit_price,
            'sale' => $course->sale && $course->sale_key,
            'sale_key' => $course->sale_key,
            'sale_price' => $course->sale,
            'additional_description' => $course->additional_description,
            'feed_id' => $course->feed_id,
            'sort_order_in_schools' => $course->sort_order_in_schools,
            'sort_order_in_categories' => $course->sort_order_in_categories,
            'url' => $course->url,
            'image' => $course->getFirstMedia('course-preview')?->getUrl()
        ]);
    }
}
