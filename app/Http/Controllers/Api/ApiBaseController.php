<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeMedia(Request $request)
    {
        $model = $request->model;
        $entity = app($model)->find($request->id);
        if ($entity && $entity->hasMedia($request->media)) {
            $entity->getFirstMedia($request->media)->delete();
            return response()->json(['success' => true, 'message' => 'Медиа удалено']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка!']);
        }
    }
}
