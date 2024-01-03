<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationColumnInterface;
use App\Http\Requests\ConfigurationColumnRequest;

class ConfigurationColumnController extends Controller
{
    protected ConfigurationColumnInterface $configurationColumnService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ConfigurationColumnInterface::class, ConfigurationColumnRequest::class);
    }
}
