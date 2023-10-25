<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\ContactResponseInterface;
use App\Http\Requests\ContactResponseRequest;

class ContactResponseController extends Controller
{
    protected ContactResponseInterface $contactResponseService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ContactResponseInterface::class, ContactResponseRequest::class);
    }
}
