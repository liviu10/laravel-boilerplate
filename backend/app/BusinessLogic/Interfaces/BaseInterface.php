<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface BaseInterface
{
    public function handleIndex(array $search): Response|ResponseFactory;

    public function handleStore(array $request): Response|ResponseFactory;

    public function handleShow(int $id): Response|ResponseFactory;

    public function handleUpdate(array $request, int $id): Response|ResponseFactory;

    public function handleDestroy(int $id): Response|ResponseFactory;

    public function handleResourcePermissions(): void;
}
