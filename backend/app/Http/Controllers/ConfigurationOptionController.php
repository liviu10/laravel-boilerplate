<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationOptionInterface;
use App\Http\Requests\ConfigurationOptionRequest;

class ConfigurationOptionController extends Controller
{
    protected ConfigurationOptionInterface $configurationOptionService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ConfigurationOptionInterface::class, ConfigurationOptionRequest::class);
    }
}
