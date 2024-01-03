<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationTranslationInterface;
use App\Http\Requests\ConfigurationTranslationRequest;

class ConfigurationTranslationController extends Controller
{
    protected ConfigurationTranslationInterface $configurationTranslationService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ConfigurationTranslationInterface::class, ConfigurationTranslationRequest::class);
    }
}
