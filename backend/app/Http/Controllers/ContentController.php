<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ContentInterface;
use App\Http\Requests\ContentRequest;

class ContentController extends Controller
{
    protected ContentInterface $contentService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ContentInterface::class, ContentRequest::class);
    }
}
