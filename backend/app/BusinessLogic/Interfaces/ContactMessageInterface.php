<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface ContactMessageInterface
{
    public function handleContactMessage(array $request): Response|ResponseFactory;
}
