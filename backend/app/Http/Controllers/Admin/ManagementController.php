<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $routes = collect(Route::getRoutes()->getRoutesByMethod()['GET'])
            ->filter(function ($route) {
                return str_contains($route->uri(), 'management') && str_ends_with($route->getName(), '.index');
            })
            ->map(function ($route) {
                return str_replace('admin/', '', $route->uri());
            })
            ->values()
            ->toArray();

        $data = [
            [
                'id' => 1,
                'title' => 'Content type',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 2,
                'title' => 'Content visibility',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 3,
                'title' => 'Content',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 4,
                'title' => 'Tags',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 5,
                'title' => 'Media type',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 6,
                'title' => 'Media',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 7,
                'title' => 'Comments',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 8,
                'title' => 'Appreciations',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ]
        ];

        foreach ($routes as $index => $route) {
            $data[$index]['path'] = $route;
        }

        return Inertia::render('AdminManagement', [
            'data' => $data
        ]);
    }
}
