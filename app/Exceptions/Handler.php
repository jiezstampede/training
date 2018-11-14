<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof \Illuminate\Session\TokenMismatchException){
              return redirect()
                  ->back()
                  ->withInput($request->except('_token'))
                  ->withMessage('Sent data encountered authentication problem.');
        }
        //revert to old value to fix the admin error..
        return parent::render($request, $e);
        // if (env('APP_DEBUG')) {
        //     // In development show exception
        //     return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);

        // }
        // else {
        //      if ($this->isHttpException($e)) {
        //         // Show error for status code, if it exists
        //         $status = $e->getStatusCode();
        //         if (view()->exists("errors.{$status}")) {
        //             return response()->view("errors.{$status}", ['exception' => $e], $status);
        //         }   
        //     }
        // }
        // return response()->view("errors.generic", ['exception' => $e,'status'=> $status], $status);
    }
}
