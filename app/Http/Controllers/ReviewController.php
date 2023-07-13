<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

class ReviewController extends Controller
{
    const PATH = 'reviews.';
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $title = 'Управление отзывами';
        return view(self::PATH . 'index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $title = 'Добавить отзыв';
        $breadcrumbs[] = [
            'url' => route('reviews.index'),
            'title' => 'Все отзывы'
        ];

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Добавить'
        ];

        return view(self::PATH . 'edit', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $title = 'Редактирование отзыва';
        $breadcrumbs[] = [
            'url' => route('reviews.index'),
            'title' => 'Все отзывы'
        ];
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Редактировать'
        ];

        return view(self::PATH . 'edit', compact('title', 'breadcrumbs', 'id'));
    }
}
