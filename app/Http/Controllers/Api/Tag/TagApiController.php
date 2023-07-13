<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Services\Interfaces\TagService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagApiController extends Controller
{
    /**
     * TagApiController constructor.
     *
     * @param TagService $tagService
     */
    public function __construct(
        private TagService $tagService
    ) {
    }

    public function getById(int $id): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $this->tagService->getById($id)
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getAll() : JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            ['results' => $this->tagService->get()]
        );
    }

    /**
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function save(TagRequest $request): JsonResponse
    {
        $this->tagService->save($request);
        return ResponseService::sendJsonResponse(true, 200, null, ['message' => 'Тег успешно сохранен']);
    }

    public function destroy(Request $request): JsonResponse
    {
        $this->tagService->destroy($request);
        return ResponseService::sendJsonResponse(true);
    }
}
