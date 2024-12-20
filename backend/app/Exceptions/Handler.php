<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
         if ($request->is('api/*')) {  
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => $exception->errors(),
                ], 422);
            }

            if ($exception instanceof QueryException) {
                return response()->json([
                    'error' => 'Database error occurred',
                    'message' => $exception->getMessage()
                ], 500);
            }
        }

        return parent::render($request, $exception);
    }
}