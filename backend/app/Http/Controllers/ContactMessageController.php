<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ContactMessageInterface;
use App\Http\Requests\ContactMessageRequest;

class ContactMessageController extends Controller
{
    protected ContactMessageInterface $contactMessageService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ContactMessageInterface::class, ContactMessageRequest::class);
    }
}
