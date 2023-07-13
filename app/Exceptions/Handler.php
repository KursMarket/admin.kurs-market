<?php

namespace App\Exceptions;

use App\Services\Response\ResponseService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this
            ->renderable(function (CategoryHasChildrenException $exception, Request $request) {
                if ($request->is('api/*')) {
                    return ResponseService::sendJsonResponse(false, 409, ['message' => $exception->getMessage()]);
                } else {
                    return response()->view('_includes._embed._errors.category-has-children', [], 409);
                }
            })
        ;

        $this
            ->renderable(function (CategorySaveException $exception) {
                return ResponseService::sendJsonResponse(
                    false,
                    419,
                    [
                        'message' => $exception->getMessage(),
                        'errorMessage' => $exception->getErrorMessage(),
                        'file' => $exception->getFile()
                    ]
                );
            })
        ;

        $this
            ->renderable(function (AuthException $exception) {
                return ResponseService::sendJsonResponse(
                    false,
                    422,
                    [
                        'message' => $exception->getMessage(),
                        'errorMessage' => $exception->getErrorMessage(),
                        'file' => $exception->getFile()
                    ]
                );
            })
        ;

        $this
            ->renderable(function (BadRequestException $exception) {
                return ResponseService::sendJsonResponse(
                    false,
                    400,
                    [
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile()
                    ]
                );
            })
        ;

        $this
            ->renderable(function (NotFoundException $exception) {
                return ResponseService::sendJsonResponse(
                    false,
                    404,
                    [
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile()
                    ]
                );
            })
        ;
    }
}
