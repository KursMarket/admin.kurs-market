<?php

namespace App\Http\Controllers;

class SchoolController extends Controller
{
    const PATH = 'schools.';

    public function index()
    {
        $data['title'] = 'Управление школами';
        $data['breadcrumbs'][] = [
            'url' => '',
            'title' => 'Все школы'
        ];

        return view(self::PATH . 'index', $data);
    }

    public function create()
    {
        $data['title'] = 'Добавить школу';
        $data['breadcrumbs'][] = [
            'url' => route('schools.index'),
            'title' => 'Все школы'
        ];

        $data['breadcrumbs'][] = [
            'url' => '',
            'title' => 'Добавить'
        ];
        return view(self::PATH . 'edit', $data);
    }

    public function edit(int $id)
    {
        $data['title'] = 'Редактировать школу';
        $data['breadcrumbs'][] = [
            'url' => route('schools.index'),
            'title' => 'Все школы'
        ];

        $data['breadcrumbs'][] = [
            'url' => '',
            'title' => 'Редактировать'
        ];

        $data['school_id'] = $id;
        return view(self::PATH . 'edit', $data);
    }
}
