<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationTypeInterface;
use App\Http\Requests\ConfigurationTypeRequest;

class ConfigurationTypeController extends Controller
{
    protected ConfigurationTypeInterface $configurationTypeService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ConfigurationTypeInterface::class, ConfigurationTypeRequest::class);
    }
}
