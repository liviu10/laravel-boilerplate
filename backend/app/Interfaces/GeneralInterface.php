<?php

namespace App\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Interface GeneralInterface
 *
 * @package App\Interfaces
 */
interface GeneralInterface
{
    /**
     * Handle fetch model names operation.
     *
     * @return Response|ResponseFactory
     */
    public function fetchModelNames(): Response|ResponseFactory;

    /**
     * Handle apply migrations operation.
     *
     * @return Response|ResponseFactory
     */
    public function applyMigrations(): Response|ResponseFactory;

    /**
     * Handle apply seeders operation.
     *
     * @return Response|ResponseFactory
     */
    public function applySeeders(): Response|ResponseFactory;

    /**
     * Handle optimize application operation.
     *
     * @return Response|ResponseFactory
     */
    public function optimizeApplication(): Response|ResponseFactory;
}
