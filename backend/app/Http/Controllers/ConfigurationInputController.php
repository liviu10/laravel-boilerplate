<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ConfigurationInputInterface;
use App\Http\Requests\ConfigurationInputRequest;

class ConfigurationInputController extends Controller
{
    protected ConfigurationInputInterface $configurationInputService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ConfigurationInputInterface::class, ConfigurationInputRequest::class);
    }
}
