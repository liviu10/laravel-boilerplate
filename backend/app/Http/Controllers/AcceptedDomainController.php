<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\AcceptedDomainInterface;
use App\Http\Requests\AcceptedDomainRequest;

use Illuminate\Support\Facades\Route;

class AcceptedDomainController extends Controller
{
    protected AcceptedDomainInterface $acceptedDomainService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(AcceptedDomainInterface::class, AcceptedDomainRequest::class);

        $routes = Route::getRoutes();

        // Initialize an array to store route names associated with the controller
        $routeNames = [];

        foreach ($routes as $route) {
            $action = $route->getAction();
            dd($action);

            // Check if the route uses the specified controller
            if (isset($action['controller']) && $action['controller'] === __NAMESPACE__ . '\\' . basename(AcceptedDomainController::class)) {
                $name = $route->getName();

                // Make sure the route has a name before adding it to the array
                if ($name) {
                    $routeNames[] = $name;
                }
            }
        }

        dd($routeNames);
    }
}
