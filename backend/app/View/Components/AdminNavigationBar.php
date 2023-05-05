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
        $usersIsVisible = true;
        $userRolesIsVisible = true;

        if (Auth::user()->user_role_type_id === 5)
        {
            $usersIsVisible = false;
            $userRolesIsVisible = false;
        }
        $this->adminNavigationBar = [
            'applicationName' => config('app.name'),
            'homePage' => __('admin.navbar.home'),
            'sections' => __('admin.navbar.sections.title'),
            'contactPage' => __('admin.navbar.sections.contact_page'),
            'viewWebsite' => __('admin.navbar.view_website'),
            'welcome' => __('admin.general.welcome_message', [ 'userName' => Auth::user()->full_name ]),
            'profile' => __('admin.navbar.profile'),
            'users' => __('admin.navbar.users'),
            'roles' => __('admin.navbar.roles'),
            'logout' => __('admin.navbar.logout'),
            'users_is_visible' => $usersIsVisible,
            'user_roles_is_visible' => $userRolesIsVisible
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
