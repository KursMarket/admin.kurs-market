<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudyDurationController extends Controller
{
    const PATH = 'durations.';

    public function index(): Factory|View|Application
    {
        $title = 'Управление длительностью';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все позиции'
        ];
        return view(self::PATH . 'index', compact('title', 'breadcrumbs'));
    }

    public function create(): Factory|View|Application
    {
        $title = 'Добавить длительность';
        $breadcrumbs[] = [
            'url' => route('durations.index'),
            'title' => 'Все позиции'
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
        $title = 'Редактировать длительность';
        $breadcrumbs[] = [
            'url' => route('durations.index'),
            'title' => 'Все позиции'
        ];

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Редактировать'
        ];
        return view(self::PATH . 'edit', compact('title', 'breadcrumbs', 'id'));
    }
}
