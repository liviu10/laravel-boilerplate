<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\AcceptedDomainInterface;
use App\Http\Requests\AcceptedDomainRequest;

class AcceptedDomainController extends Controller
{
    protected AcceptedDomainInterface $acceptedDomainService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(AcceptedDomainInterface::class, AcceptedDomainRequest::class);
    }
}
