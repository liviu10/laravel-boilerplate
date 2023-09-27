<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\NewsletterSubscriberInterface;
use App\Http\Requests\NewsletterSubscriberRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class NewsletterSubscriberController extends Controller
{
    protected NewsletterSubscriberInterface $newsletterSubscriberService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(NewsletterSubscriberInterface $newsletterSubscriberService)
    {
        $this->newsletterSubscriberService = $newsletterSubscriberService;
        parent::__construct(NewsletterSubscriberInterface::class, NewsletterSubscriberRequest::class);
    }

    /**
     * Unsubscribe user from the newsletter. HTTP request [DELETE].
     * @param string $email The email of the user to be deleted.
     * @return Response|ResponseFactory The response indicating the result of the deletion or a response factory.
     */
    public function unsubscribe(string $email): Response|ResponseFactory
    {
        return $this->newsletterSubscriberService->handleUnsubscribe($email);
    }
}
