<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiStatisticalIndicators;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeService
{
    use ApiStatisticalIndicators;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the index action for displaying a list of records.
     * @return Response|ResponseFactory|View The response containing the list of records,
     * a response factory or a view template.
     */
    public function handleIndex(): Response|ResponseFactory|View
    {
        return view('pages.admin.index');
    }
}
