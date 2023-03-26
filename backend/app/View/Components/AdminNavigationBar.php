<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
            'applicationName' => config('app.name'),
            'homePage' => __('admin.navbar.home'),
            'sections' => __('admin.navbar.sections.title'),
            'firstPage' => __('admin.navbar.sections.first_page'),
            'secondPage' => __('admin.navbar.sections.second_page'),
            'thirdPage' => __('admin.navbar.sections.third_page'),
            'viewWebsite' => __('admin.navbar.view_website'),
            'welcome' => __('admin.navbar.welcome', [ 'userName' => Auth::user()->full_name ]),
            'profile' => __('admin.navbar.profile'),
            'users' => __('admin.navbar.users'),
            'logout' => __('admin.navbar.logout')
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-navigation-bar')->with('adminNavigationBar', $this->adminNavigationBar);
    }
}
