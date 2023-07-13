<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\ReviewResource;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewApiController extends Controller
{
    /**
     * CourseApiController constructor.
     *
     * @param ReviewServiceInterface $reviewService
     */
    public function __construct(private ReviewServiceInterface $reviewService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $results = $this->reviewService->getAllWithPaginate($request);
        return ResponseService::sendJsonResponse(true, Response::HTTP_OK, null,
            [
                'reviews' => $results['reviews'],
                'total' => $results['total']
            ]
        );
    }

    public function getReviewStatusesList(): JsonResponse
    {
        return ResponseService::sendJsonResponseApi(true, Response::HTTP_OK, null, $this->reviewService->getStatusesList());
    }

    public function getReviewSourcesList(): JsonResponse
    {
        return ResponseService::sendJsonResponseApi(true, Response::HTTP_OK, null, $this->reviewService->getSourcesList());
    }

    public function getReviewUsersList(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            Response::HTTP_OK,
            null,
            ['users' => $this->reviewService->getUsersList()]
        );
    }

    public function statusChange(Request $request): JsonResponse
    {
        $this->reviewService->updateStatuses($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->reviewService->save($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ReviewResource
     */
    public function show(int $id): ReviewResource
    {
        return $this->reviewService->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->reviewService->save($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $this->reviewService->destroyMultiple($request);
        return ResponseService::sendJsonResponse(true);
    }
}
