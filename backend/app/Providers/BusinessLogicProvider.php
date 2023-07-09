<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import application's settings
use App\BusinessLogic\Interfaces\Admin\Settings\FrontMenuInterface;
use App\BusinessLogic\Services\Admin\Settings\FrontMenuService;
use App\BusinessLogic\Interfaces\Admin\Settings\UserInterface;
use App\BusinessLogic\Services\Admin\Settings\UserService;
use App\BusinessLogic\Interfaces\Admin\Settings\UserRoleTypeInterface;
use App\BusinessLogic\Services\Admin\Settings\UserRoleTypeService;

class BusinessLogicProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register application's settings interfaces and services
        $this->app->bind( FrontMenuInterface::class, FrontMenuService::class );
        $this->app->bind( UserInterface::class, UserService::class );
        $this->app->bind( UserRoleTypeInterface::class, UserRoleTypeService::class );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
