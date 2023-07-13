<?php

namespace App\Http\Controllers\Api\Course;

use App\Helpers\CourseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Services\Interfaces\CourseService;
use App\Services\Interfaces\StudyDurationService;
use App\Services\Interfaces\TagService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseApiController extends Controller
{
    /**
     * CourseApiController constructor.
     *
     * @param CourseService $courseService
     * @param TagService $tagService
     * @param StudyDurationService $studyDurationService
     * @param CourseHelper $courseHelper
     */
    public function __construct(
        private CourseService $courseService,
        private TagService $tagService,
        private StudyDurationService $studyDurationService,
        private CourseHelper $courseHelper
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $results = $this->courseService->getAllWithPaginate($request);
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'courses' => $results['courses'],
                'total' => $results['total']
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getSchools(): JsonResponse
    {
        $results = $this->courseHelper->getSchoolListForFiltering();

        return ResponseService::sendJsonResponse(true, 200, null, ['results' => $results]);
    }

    /**
     * @return JsonResponse
     */
    public function getStatuses(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            ['results' => $this->courseHelper->getStatusesForFiltering()]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            ['results' => $this->courseHelper->getCategoriesForFiltering()]
        );
    }

    /**
     * @param int $categoryId
     * @return JsonResponse
     */
    public function getSubCategoriesByCategoryId(int $categoryId): JsonResponse
    {
        $subCats = $this->courseHelper->getCategoriesForFiltering($categoryId);
        return ResponseService::sendJsonResponse(true, 200, null, ['results' => $subCats]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function statusesChange(Request $request): JsonResponse
    {
        $this->courseService->updateMultipleStatus($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        $this->courseService->destroy($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @return JsonResponse
     */
    public function getTags(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'results' => $this->tagService->getForSelection()
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getDurations(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'results' => $this->studyDurationService->getForSelection()
            ]
        );
    }

    /**
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function save(CourseRequest $request): JsonResponse
    {
        $course = $this->courseService->save($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function findById(int $id): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'course' => $this->courseService->findById($id)
            ]
        );
    }

    public function deleteImage(int $courseId): JsonResponse
    {
        $this->courseService->destroyImage($courseId);
        return ResponseService::sendJsonResponse(true);
    }

    public function getAllCoursesList(): JsonResponse
    {
        $results = $this->courseService->getCoursesListForFiltering();

        return ResponseService::sendJsonResponse(true, 200, null, ['results' => $results]);
    }
}
