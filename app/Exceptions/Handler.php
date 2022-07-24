<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => Response::$statusTexts[Response::HTTP_NOT_FOUND],
                'info' => 'Endpoint or register not found',
            ], Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'status' => $e->status,
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'This action is unauthorized',
            ], Response::HTTP_FORBIDDEN);
        });
    }
}
