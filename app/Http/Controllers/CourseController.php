<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

class CourseController extends Controller
{
    const PATH = 'courses.';

    public function index(): Factory|View|Application
    {
        $title = 'Управление курсами';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все курсы'
        ];

        return view(self::PATH . 'index', compact('title', 'breadcrumbs'));
    }

    public function create(): Factory|View|Application
    {
        $title = 'Добавление курса    ';
        $breadcrumbs[] = [
            'url' => route('courses.index'),
            'title' => 'Все курсы'
        ];
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Добавить'
        ];

        return view(self::PATH . 'create', compact('title', 'breadcrumbs'));
    }

    public function edit($id): Factory|View|Application
    {
        $title = 'Редактирование курса    ';
        $breadcrumbs[] = [
            'url' => route('courses.index'),
            'title' => 'Все курсы'
        ];
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Редактировать'
        ];

        return view(self::PATH . 'create', compact('title', 'breadcrumbs', 'id'));
    }
}
