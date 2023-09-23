<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait LogApiError
{
    /**
     * Log an API error to the application's error log.
     * @param Exception $mysqlError The exception representing the API error.
     * @return void
     */
    public function LogApiError(Exception $mysqlError): void
    {
        $logError = [
            'code'        => $mysqlError->getCode(),
            'description' => $mysqlError->getMessage()
        ];
        Log::error($logError);
    }
}
