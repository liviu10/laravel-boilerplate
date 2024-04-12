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
            'communication_title' => 'Communication',
            'communication_url' => route('communication.index'),
            'management_title' => 'Management',
            'management_url' => route('management.index'),
            'settings_title' => 'Settings',
            'settings_url' => route('settings.index'),
            'view_website_title' => 'View Website',
            'view_website_url' => route('guest.index'),
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
}
