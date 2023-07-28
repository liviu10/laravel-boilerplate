<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import application's communication settings
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMeMessageInterface;
use App\BusinessLogic\Services\Admin\Communication\ContactMeMessageService;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMeSubjectInterface;
use App\BusinessLogic\Services\Admin\Communication\ContactMeSubjectService;

// Import application's user settings
use App\BusinessLogic\Interfaces\Admin\Settings\UserInterface;
use App\BusinessLogic\Services\Admin\Settings\UserService;
use App\BusinessLogic\Interfaces\Admin\Settings\RoleAndPermissionInterface;
use App\BusinessLogic\Services\Admin\Settings\RoleAndPermissionService;

// Import application's settings
use App\BusinessLogic\Interfaces\Admin\ApplicationSettings\AcceptedDomainInterface;
use App\BusinessLogic\Services\Admin\ApplicationSettings\AcceptedDomainService;

class BusinessLogicProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register application's communication settings interfaces and services
        $this->app->bind( ContactMeMessageInterface::class, ContactMeMessageService::class );
        $this->app->bind( ContactMeSubjectInterface::class, ContactMeSubjectService::class );

        // Register application's user settings interfaces and services
        $this->app->bind( UserInterface::class, UserService::class );
        $this->app->bind( RoleAndPermissionInterface::class, RoleAndPermissionService::class );

        // Register application's settings interfaces and services
        $this->app->bind( AcceptedDomainInterface::class, AcceptedDomainService::class );
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
