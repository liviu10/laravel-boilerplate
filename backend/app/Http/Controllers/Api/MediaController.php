<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\MediaInterface;
use App\Http\Requests\MediaRequest;

class MediaController extends Controller
{
    protected MediaInterface $mediaService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(MediaInterface::class, MediaRequest::class);
    }
}
