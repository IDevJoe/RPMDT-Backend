<?php

namespace App\Exceptions;

use App\CannedResponse;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $e)
    {
        if (app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException) {
            return CannedResponse::Unprocessable($exception->errors());
        }
        if(array_search(get_class($exception), $this->dontReport) !== -1) {
            $render = parent::render($request, $exception);
            $sc = $render->getStatusCode();
            switch($sc) {
                case 404:
                    return CannedResponse::NotFound();
                case 401:
                    return CannedResponse::Fortbidden();
                case 403:
                    return CannedResponse::Unauthorized();
                case 400:
                    return CannedResponse::BadRequest();
            }
            return CannedResponse::main($render->getStatusCode(), null);
        }
        $render =  parent::render($request, $exception);
        if(App::environment() == 'development') return $render;
        else return CannedResponse::main($render->getStatusCode(), null);
    }
}
