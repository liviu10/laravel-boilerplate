<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationResourceInterface;
use App\Http\Requests\ConfigurationResourceRequest;

class ConfigurationResourceController extends Controller
{
    protected ConfigurationResourceInterface $configurationResourceService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ConfigurationResourceInterface::class, ConfigurationResourceRequest::class);
    }
}
