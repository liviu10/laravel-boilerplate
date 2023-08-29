<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\RoleInterface;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    protected RoleInterface $roleService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(RoleInterface::class, RoleRequest::class);
    }
}
