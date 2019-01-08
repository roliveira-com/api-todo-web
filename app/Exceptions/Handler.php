<?php

namespace App\Exceptions;

use Response;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof UnauthorizedHttpException) {

            $preException = $exception->getPrevious();
        
            if ($preException instanceof TokenExpiredException) {        
                return response()->json(['error' => 'TOKEN_EXPIRED'], 403);        
            } else if ($preException instanceof TokenInvalidException) {        
                return response()->json(['error' => 'TOKEN_INVALID'], 403);        
            } else if ($preException instanceof TokenBlacklistedException) {        
                 return response()->json(['error' => 'TOKEN_BLACKLISTED'], 403);        
           }
        
           if ($exception->getMessage() === 'Token not provided') {        
               return response()->json(['error' => 'TOKEN_NOT_PROVIDED'], 403);        
           }
        
        }
        return parent::render($request, $exception);
    }
}
