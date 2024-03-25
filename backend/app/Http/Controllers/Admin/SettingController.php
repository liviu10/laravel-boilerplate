<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $routes = collect(Route::getRoutes()->getRoutesByMethod()['GET'])
            ->filter(function ($route) {
                return str_contains($route->uri(), 'settings') && str_ends_with($route->getName(), '.index');
            })
            ->map(function ($route) {
                return str_replace('admin/', '', $route->uri());
            })
            ->values()
            ->toArray();

        $data = [
            [
                'id' => 1,
                'title' => 'General',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 2,
                'title' => 'Notification types',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 3,
                'title' => 'Notifications',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 4,
                'title' => 'Resources',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
            [
                'id' => 5,
                'title' => 'Users',
                'description' => 'Description  here',
                'path' => '',
                'button_label' => 'View',
            ],
        ];

        foreach ($routes as $index => $route) {
            $data[$index]['path'] = $route;
        }

        return Inertia::render('AdminSettings', [
            'data' => $data
        ]);
    }
}
