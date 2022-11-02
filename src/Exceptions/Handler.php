<?php

namespace Spreader\Handler\Exceptions;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        switch (true) {
            case $e instanceof NotFoundHttpException:
                return response()->json(['message' => 'Route not found'], Response::HTTP_NOT_FOUND);
            case $e instanceof ValidationException:
                return response()->json($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            case $e instanceof ModelNotFoundException:
                return response()->json(['status' => false, 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            default:
                return response()->json(
                    ['message' => config('app.debug') ? $e->getMessage() . ' in file ' . $e->getFile() . ' : ' . $e->getLine() : 'Server error'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }
}
