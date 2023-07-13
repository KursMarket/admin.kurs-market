<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    const PATH = 'news.';
    private NewsService $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data['types'] = News::getTypes();
        $data['levels'] = News::getArticlesLevels();
        $data['title'] = 'Управление новостями';
        $data['breadcrumbs'][] = [
            'url' => '',
            'title' => 'Все нововсти'
        ];
        $data['news'] = $this->service->getNewsWithPaginate($request);
        return view(self::PATH . 'index', $data);
    }


    public function create()
    {
        $data['types'] = News::getTypes();
        $data['levels'] = News::getArticlesLevels();
        $data['title'] = 'Создание новости';
        $data['breadcrumbs'][] = [
            'url' => route('news.index'),
            'title' => 'Все новости'
        ];

        $data['breadcrumbs'][] = [
            'url' => '',
            'title' => 'Создать'
        ];
        return view(self::PATH . 'create', $data);
    }


    public function store(NewsRequest $request)
    {
        $model = new News();
        $news = $this->service->save($request, $model);
        return redirect()->route('news.index')->with(['message' => 'Новость "'. $news->title .'" сохранена']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data['item'] = News::find($id);

        $data['title'] = 'Управление новостями';

        $data['breadcrumbs'][] = [
            'url' => route('news.index'),
            'title' => 'Все новости'
        ];

        $data['breadcrumbs'][] = [
            'url' => '',
            'title' => $data['item']->title
        ];

        $data['types'] = News::getTypes();
        $data['levels'] = News::getArticlesLevels();

        return view(self::PATH . 'edit', $data);
    }


    public function update(NewsRequest $request, $id)
    {
        $model = News::find($id);
        $this->service->save($request, $model);
        return redirect()->route('news.index')->with(['message' => 'Новость "'. $model->title .'" обновлена']);
    }


    public function destroy($id)
    {
        $this->service->delete((int)$id);
        return redirect()->back()->with(['message' => 'Новость удалена']);
    }
}
