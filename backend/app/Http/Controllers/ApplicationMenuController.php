<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ApplicationMenuInterface;
use App\Http\Requests\ApplicationMenuRequest;

class ApplicationMenuController extends Controller
{
    protected ApplicationMenuInterface $applicationMenuService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ApplicationMenuInterface::class, ApplicationMenuRequest::class);
    }
}
