<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface ConfigurationResourceInterface
{
    public function handleStatisticalIndicators(): array;

    public function handleGetConfiguration(array $key): Response|ResponseFactory;
}
