<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\Http\Requests\AcceptedDomainRequest;

class AcceptedDomainController extends Controller
{
    protected BaseInterface $acceptedDomainService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(BaseInterface::class, AcceptedDomainRequest::class);
    }
}
