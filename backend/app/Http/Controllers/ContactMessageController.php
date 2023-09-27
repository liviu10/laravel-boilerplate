<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ContactMessageInterface;
use App\Http\Requests\ContactMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class ContactMessageController extends Controller
{
    protected ContactMessageInterface $contactMessageService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(ContactMessageInterface $contactMessageService)
    {
        $this->contactMessageService = $contactMessageService;
        parent::__construct(ContactMessageInterface::class, ContactMessageRequest::class);
    }

    /**
     * Contact message. HTTP request [POST].
     * @param \Illuminate\Http\Request $request The HTTP request instance containing the data to be stored.
     * @return Response|ResponseFactory The response indicating the result of the deletion or a response factory.
     */
    public function contactMessage(Request $request): Response|ResponseFactory
    {
        return $this->contactMessageService->handleContactMessage($request->toArray());
    }
}
