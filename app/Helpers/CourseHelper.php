<?php


namespace App\Helpers;


use App\Dto\CategorySchoolForFilterDto;
use App\Dto\CourseSchoolResultForFilters;
use App\Models\Category;
use App\Models\Course;
use App\Models\School;
use Illuminate\Support\Collection;

class CourseHelper
{
    /**
     * @return Collection
     */
    public function getSchoolListForFiltering(): Collection
    {
        return School::select(['user_id as id', 'user_id', 'name'])
            ->orderBy('name')
            ->get()
            ->map(fn(School $course): CourseSchoolResultForFilters => CourseSchoolResultForFilters::toDto($course));
    }

    /**
     * @return array[]
     */
    public function getStatusesForFiltering(): array
    {
        return [
            ['id' => Course::ACTIVE_STATUS, 'text' => 'Опубликован', 'color' => '#9DC892'],
            ['id' => Course::MODERATION_STATUS, 'text' => 'На модерации', 'color' => '#F3E4AB'],
            ['id' => Course::REJECTED_STATUS, 'text' => 'Отклонен', 'color' => '#D75D5D'],
            ['id' => Course::HIDDEN_STATUS, 'text' => 'Скрыт', 'color' => 'rgba(215, 93, 93, 0.4)'],
        ];
    }

    /**
     * @param int|null $categoryId
     * @return Collection
     */
    public function getCategoriesForFiltering(?int $categoryId = null): Collection
    {
        $categories = Category::select(['id', 'title']);

        if (null !== $categoryId && 0 !== $categoryId) {
            $categories->where('parent_id', $categoryId);
        } else {
            $categories->whereNull('parent_id');
        }

        return $categories
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->map(fn(Category $category): CategorySchoolForFilterDto => CategorySchoolForFilterDto::toDto($category));
    }
}
