<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationResourceInterface;
use App\Http\Requests\ConfigurationResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class ConfigurationResourceController extends Controller
{
    protected ConfigurationResourceInterface $configurationResourceService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(ConfigurationResourceInterface $configurationResourceService)
    {
        $this->configurationResourceService = $configurationResourceService;
        parent::__construct(ConfigurationResourceInterface::class, ConfigurationResourceRequest::class);
    }

    public function getConfiguration(Request $request): Response|ResponseFactory
    {
        return $this->configurationResourceService->handleGetConfiguration($request->all());
    }
}
