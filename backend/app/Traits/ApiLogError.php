<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ApiLogError
{
    /**
     * Handle API log error.
     * This function is responsible for handling and logging API-related errors that
     * occur during MySQL operations.
     * @param \Exception|\Throwable $mysqlError The exception or throwable representing the MySQL error.
     * @return void
     */
    public function handleApiLogError($mysqlError)
    {
        $logError = [
            'code'        => $mysqlError->getCode(),
            'description' => $mysqlError->getMessage()
        ];
        Log::error($logError);
    }
}
