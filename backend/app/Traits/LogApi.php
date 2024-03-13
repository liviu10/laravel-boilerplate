<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait LogApi
{
    /**
     * Log an API to the application's log.
     * @param Exception $exception The exception representing the API.
     * @return void
     */
    public function LogApi(Exception $exception): void
    {
        Log::error($exception);
    }
}
