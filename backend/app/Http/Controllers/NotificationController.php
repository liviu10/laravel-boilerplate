<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\NotificationInterface;
use App\Http\Requests\NotificationRequest;

class NotificationController extends Controller
{
    protected NotificationInterface $notificationService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(NotificationInterface::class, NotificationRequest::class);
    }
}
