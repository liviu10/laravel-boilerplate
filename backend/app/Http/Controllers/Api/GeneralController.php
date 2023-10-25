<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\GeneralInterface;
use App\Http\Requests\GeneralRequest;

class GeneralController extends Controller
{
    protected GeneralInterface $generalService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(GeneralInterface::class, GeneralRequest::class);
    }
}
