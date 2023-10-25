<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\CommentInterface;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    protected CommentInterface $commentService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(CommentInterface::class, CommentRequest::class);
    }
}
