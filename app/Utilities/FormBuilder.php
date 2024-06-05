<?php

namespace App\Utilities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;

class FormBuilder
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the response.
     *
     * @return array
     */
    public function handleFormBuilder(): array
    {
        return [];
    }
}
