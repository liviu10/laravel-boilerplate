<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class AdminNavigationBar extends Component
{
    public array $adminNavigationBar;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->adminNavigationBar = [
            'title' => 'Home',
            'url' => route('admin.index'),
            'communication' => [
                'title' => 'Communication',
                'children' => $this->getRouteChildren('communication'),
            ],
            'management' => [
                'title' => 'Management',
                'children' => $this->getRouteChildren('management'),
            ],
            'settings' => [
                'title' => 'Settings',
                'children' => $this->getRouteChildren('settings'),
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-navigation-bar')
            ->with('adminNavigationBar', $this->adminNavigationBar);
    }

    /**
     * Get the children routes for a given group.
     */
    private function getRouteChildren(string $baseUrl): array
    {
        $routes = Route::getRoutes();

        $filteredRoutes = [];

        $id = 1;

        foreach ($routes as $route) {
            if (str_starts_with($route->uri(), "admin/{$baseUrl}") && $route->getActionMethod() === 'index') {
                $fullUrl = route($route->getName());

                $urlComponents = explode('/', $fullUrl);
                $lastElement = end($urlComponents);

                $filteredRoutes[] = [
                    'id' => $id++,
                    'title' => $lastElement,
                    'url' => $fullUrl,
                ];
            }
        }

        return ['children' => $filteredRoutes];
    }
}
