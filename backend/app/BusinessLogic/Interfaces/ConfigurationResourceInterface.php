<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface ConfigurationResourceInterface
{
    public function handleGetConfigurationResourceId(array $key): Response|ResponseFactory;
}
