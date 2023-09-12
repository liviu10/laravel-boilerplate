<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\MenuInterface;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{
    protected MenuInterface $menuService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(MenuInterface::class, MenuRequest::class);
    }
}
