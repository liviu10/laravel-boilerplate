<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogApiError
{
    /**
     * Log an API error.
     * This method logs an API error using the provided MySQL error information. It extracts
     * the error code and description from the MySQL error object and creates a log entry
     * with the error details using the Log::error() method.
     * @param \Exception $mysqlError The MySQL error object.
     * @return void
     */
    public function LogApiError($mysqlError)
    {
        $logError = [
            'code'        => $mysqlError->getCode(),
            'description' => $mysqlError->getMessage()
        ];
        Log::error($logError);
    }
}
