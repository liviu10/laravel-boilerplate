<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

/**
 * LogsErrors trait.
 * This trait provides a common error logging functionality for models that implement it.
 */
trait LogErrors
{
    /**
     * Logs an error using Laravel's built-in logging functionality.
     * @param \Exception $exception The exception to log.
     * @return void
     */
    public function logError(\Exception $exception)
    {
        $logError = [
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage()
        ];
        Log::error($logError);
    }

    /**
     * Log a database query error.
     * @param \Illuminate\Database\QueryException $exception
     * @return void
     */
    public function logQueryError(\Illuminate\Database\QueryException $exception)
    {
        $logError = [
            'query'    => $exception->getSql(),
            'message'  => $exception->getMessage(),
            'bindings' => $exception->getBindings()
        ];
        Log::error($logError);
    }
}
