<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogTypeController extends Controller
{
    const PATH = 'categories.catalog-type.';

    public function index(): Factory|View|Application
    {
        $title = 'Тип каталога';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все типы'
        ];
        return view(self::PATH . 'index', compact('title', 'breadcrumbs'));
    }

    public function create(): Factory|View|Application
    {
        $title = 'Тип каталога';

        $breadcrumbs[] = [
            'url' => route('types.index'),
            'title' => 'Все типы'
        ];

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Добавить новый'
        ];
        return view(self::PATH . 'create', compact('title', 'breadcrumbs'));
    }

    public function edit($id): Factory|View|Application
    {
        $title = 'Тип каталога';

        $breadcrumbs[] = [
            'url' => route('types.index'),
            'title' => 'Все типы'
        ];

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Редактировать'
        ];

        return view(self::PATH . 'edit', compact('id', 'breadcrumbs', 'title'));
    }
}
