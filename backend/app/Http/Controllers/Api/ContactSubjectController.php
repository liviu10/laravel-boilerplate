<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\ContactSubjectInterface;
use App\Http\Requests\ContactSubjectRequest;

class ContactSubjectController extends Controller
{
    protected ContactSubjectInterface $contactSubjectService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ContactSubjectInterface::class, ContactSubjectRequest::class);
    }
}
