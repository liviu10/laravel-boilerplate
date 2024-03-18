<?php

namespace App\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

/**
 * Interface ApiInterface
 *
 * @package App\Interfaces
 */
interface ApiInterface
{
    /**
     * Handle the index operation.
     *
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function index(Request $request): Response|ResponseFactory;

    /**
     * Handle the store operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing request data.
     * @return Response|ResponseFactory
     */
    public function store(Request $request): Response|ResponseFactory;

    /**
     * Handle the show operation.
     *
     * @param string $id The identifier for the resource.
     * @param string|null $type Optional type parameter.
     * @return Response|ResponseFactory
     */
    public function show(string $id, string|null $type = null): Response|ResponseFactory;

    /**
     * Handle the update operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing update data.
     * @param string $id The identifier for the resource.
     * @return Response|ResponseFactory
     */
    public function update(Request $request, string $id): Response|ResponseFactory;

    /**
     * Handle the destroy operation.
     *
     * @param string $id The identifier for the resource to be destroyed.
     * @return Response|ResponseFactory
     */
    public function destroy(string $id): Response|ResponseFactory;
}
