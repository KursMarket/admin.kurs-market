<?php

namespace App\Http\Controllers\Api\Duration;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyDurationRequest;
use App\Services\Interfaces\StudyDurationService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudyDurationApiController extends Controller
{
    /**
     * StudyDurationApiController constructor.
     *
     * @param StudyDurationService $studyDurationService
     */
    public function __construct(
        private StudyDurationService $studyDurationService
    ) {
    }

    /**
     * @param StudyDurationRequest $request
     * @return JsonResponse
     */
    public function save(StudyDurationRequest $request): JsonResponse
    {
        $this->studyDurationService->save($request);
        return ResponseService::sendJsonResponse(true, 200, null, ['message' => 'Позиция успешно сохранена']);
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
            ['results' => $this->studyDurationService->get()]
        );
    }

    public function getById(int $id): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $this->studyDurationService->getById($id)
            ]
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $this->studyDurationService->destroy($request);
        return ResponseService::sendJsonResponse(true);
    }
}
