<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\UserInterface;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected UserInterface $userService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(UserInterface::class, UserRequest::class);
        $this->userService = app(UserInterface::class);
    }

    /**
     * Fetch current authenticated user from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    // TODO: Improve this when finishing with the login system
    // public function currentAuthUser()
    // {
    //     return $this->userService->handleCurrentAuthUser();
    // }
}
