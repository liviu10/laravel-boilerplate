<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $routes = collect(Route::getRoutes()->getRoutesByMethod()['GET'])
            ->filter(function ($route) {
                return str_contains($route->uri(), 'communication') && str_ends_with($route->getName(), '.index');
            })
            ->map(function ($route) {
                return str_replace('admin/', '', $route->uri());
            })
            ->values()
            ->toArray();

        $data = [
            [
                'id' => 1,
                'title' => 'Contact subjects',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 2,
                'title' => 'Contact messages',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 3,
                'title' => 'Contact responses',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 4,
                'title' => 'Newsletter campaigns',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 5,
                'title' => 'Newsletter subscribers',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 6,
                'title' => 'Reviews',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ]
        ];

        foreach ($routes as $index => $route) {
            $data[$index]['path'] = $route;
        }

        return Inertia::render('AdminCommunication', [
            'data' => $data
        ]);
    }
}
