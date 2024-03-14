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
     * @param Request $request An instance of Illuminate\Http\Request containing update data.
     * @param string $id The identifier for the resource.
     * @return Response|ResponseFactory
     */
    public function userProfile(Request $request, string $id): Response|ResponseFactory;
}
