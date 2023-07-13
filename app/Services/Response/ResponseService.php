<?php


namespace App\Services\Response;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    private static function responseParamsObject(bool $status, ?array $errors = [], ?array $data = []): array
    {
        return [
            'status' => $status,
            'errors' => (object)$errors,
            'data' => (object)$data
        ];
    }

    private static function responseParamsArray(bool $status, ?array $errors = [], ?array $data = []): array
    {
        return [
            'status' => $status,
            'errors' => (array)$errors,
            'data' => (array)$data
        ];
    }

    public static function sendJsonResponse(bool $status, ?int $code = Response::HTTP_OK, ?array $errors = [], ?array $data = []): JsonResponse
    {
        return response()->json(
            self::responseParamsObject($status, $errors, $data),
            $code
        );
    }

    public static function sendJsonResponseApi(bool $status, ?int $code = Response::HTTP_OK, ?array $errors = [], ?array $data = []): JsonResponse
    {
        return response()->json(
            self::responseParamsArray($status, $errors, $data),
            $code
        );
    }

    public static function success(?array $data = []): JsonResponse
    {
        return self::sendJsonResponse(true, Response::HTTP_OK, [], $data);
    }

    public static function notFound(?array $data = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_NOT_FOUND, [], $data);
    }
}
