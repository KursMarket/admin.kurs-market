<?php


namespace App\Services;


use App\Models\News;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsService
{

    public function getNewsWithPaginate(Request $request)
    {
        $news =  News::orderByDesc('created_at');

        if ($request->has('title') && $request->title) {
            $news->where(DB::raw('lcase(title)'), 'like', '%'. Str::lower($request->title) .'%');
        }

        if ($request->has('date_from') && $request->date_from) {
            $news->whereDate('created_at', '>=', Carbon::parse($request->date_from)->format('Y-m-d H:i:s'));
        }

        if ($request->has('date_to') && $request->date_to) {
            $news->whereDate('created_at', '<=', Carbon::parse($request->date_to)->format('Y-m-d H:i:s'));
        }

        if ($request->has('visible_for') && $request->visible_for) {

            foreach ($request->visible_for as $k => $item) {
                $news->where(function ($q) use ($k, $item) {
                    if ((int)$k === 0) {
                        $q->where('visible_for', 'REGEXP', '.*;s:[0-9]+:"'. $item .'".*');
                    } else {
                        $q->orWhere('visible_for', 'REGEXP', '.*;s:[0-9]+:"'. $item .'".*');
                    }
                });
            }
        }
        
        return $news->paginate(20);
    }

    public function save(NewsRequest $request, News $model): News
    {
        $data = $request->all();

        $data['visible_for'] = serialize($request->visible_for);

        $model->fill($data);

        $model->save();
        if ($request->hasFile('image')) {
            if ($model->hasMedia(News::MEDIA_KEY)) {
                $model->getFirstMedia(News::MEDIA_KEY)->delete();
            }
            $model->addMedia($request->file('image'))->toMediaCollection(News::MEDIA_KEY);
        }

        if ($request->hasFile('video')) {
            if ($model->hasMedia(News::MEDIA_KEY_VIDEO)) {
                $model->getFirstMedia(News::MEDIA_KEY_VIDEO)->delete();
            }
            $model->addMedia($request->file('video'))->toMediaCollection(News::MEDIA_KEY_VIDEO);
        }

        return $model;
    }

    public function delete(int $id): void
    {
        $news = News::find($id);
        $news->delete();
    }
}
