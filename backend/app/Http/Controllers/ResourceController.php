<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ResourceInterface;
use App\Http\Requests\ResourceRequest;

class ResourceController extends Controller
{
    protected ResourceInterface $resourceService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ResourceInterface::class, ResourceRequest::class);
    }
}
