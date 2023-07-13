<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TagController extends Controller
{
    const PATH = 'tags.';

    public function index(): Factory|View|Application
    {
        $title = 'Управление тегами';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все теги'
        ];
        return view(self::PATH . 'index', compact('title', 'breadcrumbs'));
    }

    public function create(): Factory|View|Application
    {
        $title = 'Добавить тег';
        $breadcrumbs[] = [
            'url' => route('tags.index'),
            'title' => 'Все теги'
        ];

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Добавить'
        ];

        return view(self::PATH . 'edit', compact(
            'title',
            'breadcrumbs',
        ));
    }

    public function edit(int $id): Factory|View|Application
    {
        $title = 'Редактировать тег';
        $breadcrumbs[] = [
            'url' => route('tags.index'),
            'title' => 'Все теги'
        ];

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Редактировать'
        ];
        return view(self::PATH . 'edit', compact('title', 'breadcrumbs', 'id'));
    }
}
