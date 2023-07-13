<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    const PATH = 'categories.';

    public function index(): Factory|View|Application
    {
        $title = 'Управление категориями';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все категории'
        ];
        return view(self::PATH . 'index', compact('title', 'breadcrumbs'));
    }

    public function create(?int $parentCategoryId = null): Factory|View|Application
    {
        $title = 'Добавить категорию';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все категории'
        ];

        return view(self::PATH . 'edit', compact(
            'title',
            'breadcrumbs',
            'parentCategoryId'
        ));
    }

    public function edit(int $id): Factory|View|Application
    {
        $title = 'Редактировать категорию';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все категории'
        ];
        return view(self::PATH . 'edit', compact('title', 'breadcrumbs', 'id'));
    }
}
