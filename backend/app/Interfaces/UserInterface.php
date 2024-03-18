<?php

namespace App\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

/**
 * Interface UserInterface
 *
 * @package App\Interfaces
 */
interface UserInterface
{
    /**
     * Handle the update user profile operation.
     *
     * @param Request $request
     * @param string $id
     * @return Response|ResponseFactory
     */
    public function profile(Request $request, string $id): Response|ResponseFactory;
}
