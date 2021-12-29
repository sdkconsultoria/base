<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Sdkconsultoria\Base\Exceptions\APIException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        APIException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @throws \Throwable
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof APIException) {
            return response()->json(json_decode($e->getMessage()), $e->getCode());
        }

        if ($e instanceof AuthenticationException && $request->is('api/*')) {
            return response()->json([
                'message' => __('responses.401'),
                'code' => 401,
            ], 401);
        }

        if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
            return response()->json(json_decode($e->getMessage()), 500);
       }

        return parent::render($request, $e);
    }
}
