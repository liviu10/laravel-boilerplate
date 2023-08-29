<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\NewsletterSubscriberInterface;
use App\Http\Requests\NewsletterSubscriberRequest;

class NewsletterSubscriberController extends Controller
{
    protected NewsletterSubscriberInterface $newsletterSubscriberService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(NewsletterSubscriberInterface::class, NewsletterSubscriberRequest::class);
    }
}
