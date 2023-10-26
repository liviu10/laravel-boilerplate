<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ReviewInterface;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    protected ReviewInterface $reviewService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ReviewInterface::class, ReviewRequest::class);
    }
}
