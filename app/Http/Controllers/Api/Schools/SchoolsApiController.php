<?php

namespace App\Http\Controllers\Api\Schools;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\SchoolRequest;
use App\Models\School;
use App\Models\User;
use App\Services\Response\ResponseService;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolsApiController extends ApiBaseController
{
    /**
     * SchoolsApiController constructor.
     * @param SchoolService $schoolService
     */
    public function __construct(private SchoolService $schoolService)
    {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $results = $this->schoolService->getWithPaginate($request);
        $total = $this->schoolService->getTotal($request);

        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'results' => $results,
                'total' => $total
            ]
        );
    }

    /**
     * @param Request $request
     */
    public function changeStatuses(Request $request): void
    {
        $this->schoolService->updateStatuses($request);
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request): void
    {
        $this->schoolService->delete($request);
    }

    /**
     * @param SchoolRequest $request
     * @return JsonResponse
     */
    public function save(SchoolRequest $request): JsonResponse
    {
        if ($this->schoolService->saveSchool($request)) {
            return ResponseService::sendJsonResponse(
                true,
                200,
                null,
                [
                    'message' => 'Школа успешно сохранена'
                ]
            );
        }

        return ResponseService::sendJsonResponse(
            false,
            419,
            [
                'message' => 'Что-то пошло не так. Обновите страницу и повторите попытку'
            ]
        );
    }

    public function getById(Request $request): JsonResponse
    {
        $school = $this->schoolService->get($request->input('schoolId'));

        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $school
            ]
        );
    }

    public function deleteLogo(int $schoolId): JsonResponse
    {
        $school = School::find($schoolId);
        $school->user->clearMediaCollection('school-preview');
        return ResponseService::sendJsonResponse(true);
    }

    public function findBy(Request $request): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            ['results' => ($request->name ? $this->schoolService->findByName($request)  : [])]
        );
    }

    public function getAll(): JsonResponse
    {
        $results = $this->schoolService->getSchoolListForFiltering();

        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'results' => $results,
            ]
        );
    }
    public function getImage(int $id): mixed
    {
        $school = User::find($id);
        return $school->getFirstMediaUrl('school-preview');
    }
}
