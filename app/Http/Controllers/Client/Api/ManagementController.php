<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Utilities\HandleApi;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ManagementController extends Controller
{
    protected Content $modelContent;
    protected HandleApi $handleApi;

    public function __construct()
    {
        $this->modelContent = new Content();
        $this->handleApi = new HandleApi();
    }

    /**
     * Get all active contact subjects.
     *
     * @return Response|ResponseFactory
     */
    public function getContent(): Response|ResponseFactory
    {
        $query = $this->modelContent->fetchAllRecords();

        return $this->handleApi->handleApiResponse($query);
    }
}
