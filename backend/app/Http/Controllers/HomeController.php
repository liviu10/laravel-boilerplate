<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\HomeInterface;

class HomeController extends Controller
{
    protected HomeInterface $homeService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(HomeInterface::class);
    }
}
