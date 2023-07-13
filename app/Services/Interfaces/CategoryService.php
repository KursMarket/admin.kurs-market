<?php


namespace App\Services\Interfaces;


use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryService
{
    public function save(CategoryRequest $request): Category;

    public function get(?int $parent = null): mixed;

    public function delete(int $id): void;

    public function getChildren(int $parentId): array|Collection;

    public function removeRelated(int $categoryId, int $relatedId): void;
}
