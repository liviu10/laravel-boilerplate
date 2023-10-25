<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\TagInterface;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    protected TagInterface $tagService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TagInterface::class, TagRequest::class);
    }
}
