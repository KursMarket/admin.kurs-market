<?php


namespace App\Helpers;


use App\Models\Category;
use Illuminate\Support\Str;

class CategoryHelper
{
    /**
     * Make correct url from title
     *
     * @param string|null $title
     * @return string
     */
    public function makeUrlFromTitle(?string $title): string
    {
        if (null === $title) return "";

        return Str::slug($title, '-');
    }

    /**
     * Check an url already exists in db
     *
     * @param string $url
     * @param int|null $id
     * @return bool
     */
    public function checkUrl(string $url, ?int $id): bool
    {
        $category = Category::where('url', $url);
        if ($id) {
            $category->where('id', '<>', $id);
        }

        return $category->exists();
    }
}
