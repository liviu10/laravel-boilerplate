<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface NewsletterSubscriberInterface
{
    public function handleSubscribe(array $request): Response|ResponseFactory;

    public function handleUnsubscribe(string $email): Response|ResponseFactory;
}
