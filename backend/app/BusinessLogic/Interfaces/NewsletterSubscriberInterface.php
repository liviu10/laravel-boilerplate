<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface NewsletterSubscriberInterface
{
    public function handleUnsubscribe(string $email): Response|ResponseFactory;

    public function handleStatisticalIndicators(): array;
}
