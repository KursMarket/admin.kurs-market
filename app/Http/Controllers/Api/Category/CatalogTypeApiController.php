<?php


namespace App\Http\Controllers\Api\Category;


use App\Http\Requests\CatalogTypeRequest;
use App\Models\CatalogType;
use App\Services\Interfaces\CatalogTypeService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogTypeApiController
{
    /**
     * CatalogTypeApiController constructor.
     *
     * @param CatalogTypeService $catalogTypeService
     */
    public function __construct(
        private CatalogTypeService $catalogTypeService
    ) {
    }

    /**
     * @param CatalogTypeRequest $request
     * @return JsonResponse
     */
    public function save(CatalogTypeRequest $request): JsonResponse
    {
        $data = $request->all();
        if (null === $data['sort_order']) {
            $data['sort_order'] = 0;
        }

        $model = $request->has('id') && null !== $request->input('id')
            ? CatalogType::find($request->input('id'))
            : new CatalogType()
        ;

        $model->fill($data);
        $model->save();

        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $results = $this->catalogTypeService->getAll();
        return ResponseService::sendJsonResponse(true, 200, null, ['results' => $results]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getById(int $id): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $this->catalogTypeService->getById($id)
            ]
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id): JsonResponse
    {
        $this->catalogTypeService->remove($id);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeMultiple(Request $request): JsonResponse
    {
        $this->catalogTypeService->removeMultiple($request);
        return ResponseService::sendJsonResponse(true);
    }
}
