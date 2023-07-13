<?php

namespace App\Http\Controllers\Api\Category;

use App\Dto\CategoryEditDto;
use App\Helpers\CategoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Interfaces\CategoryService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * CategoryApiController constructor.
     *
     * @param CategoryService $categoryService
     * @param CategoryHelper $categoryHelper
     */
    public function __construct(
        private CategoryService $categoryService,
        private CategoryHelper $categoryHelper
    ) {
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function save(CategoryRequest $request): JsonResponse
    {
        $this->categoryService->save($request);
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'message' => 'Категория была успешно сохранена'
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function makeUrl(Request $request): JsonResponse
    {
        $url = $this->categoryHelper->makeUrlFromTitle($request->input('title'));
        $isUrlExists = $this->categoryHelper->checkUrl($url, $request->has('id') ? $request->input('id') : null);
        if ($isUrlExists) {
            return ResponseService::sendJsonResponse(
                false,
                419,
                [
                    'message' => "ЧПУ \"{$url}\" уже зарегистрирован в систиеме. Укажите другое название, или введите ЧПУ вручную"
                ]
            );
        }

        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $url
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'results' => $this->categoryService->get()
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getAllForSelect(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'results' => Category::select(['id', 'title'])->get()
            ]
        );
    }

    /**
     * @param int|string $id
     * @return JsonResponse
     */
    public function getById(int|string $id): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => CategoryEditDto::toDto(Category::find($id))
            ]
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->categoryService->delete($id);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getChildren(int $id): JsonResponse
    {
        $children = $this->categoryService->getChildren($id);
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            ['results' => $children]
        );
    }

    /**
     * @param int $relatedId
     * @param int $categoryId
     * @return void
     */
    public function removeRelated(int $categoryId, int $relatedId): void
    {
        $this
            ->categoryService
            ->removeRelated($categoryId, $relatedId)
        ;
    }
}
