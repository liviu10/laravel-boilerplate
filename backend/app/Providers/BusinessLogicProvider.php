<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import application's communication settings
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMessageInterface;
use App\BusinessLogic\Services\Admin\Communication\ContactMessageService;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactSubjectInterface;
use App\BusinessLogic\Services\Admin\Communication\ContactSubjectService;

// Import application's user settings
use App\BusinessLogic\Interfaces\Admin\Settings\UserInterface;
use App\BusinessLogic\Services\Admin\Settings\UserService;
use App\BusinessLogic\Interfaces\Admin\Settings\RoleInterface;
use App\BusinessLogic\Services\Admin\Settings\RoleService;

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
        $this->app->bind( ContactMessageInterface::class, ContactMessageService::class );
        $this->app->bind( ContactSubjectInterface::class, ContactSubjectService::class );

        // Register application's user settings interfaces and services
        $this->app->bind( UserInterface::class, UserService::class );
        $this->app->bind( RoleInterface::class, RoleService::class );

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
