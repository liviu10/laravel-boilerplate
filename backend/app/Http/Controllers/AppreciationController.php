<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\AppreciationInterface;
use App\Http\Requests\AppreciationRequest;

class AppreciationController extends Controller
{
    protected AppreciationInterface $appreciationService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(AppreciationInterface::class, AppreciationRequest::class);
    }
}
