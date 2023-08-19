<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

// Import application's management settings
use App\BusinessLogic\Interfaces\Admin\Management\ContentInterface;
use App\BusinessLogic\Interfaces\Admin\Management\TagInterface;
use App\BusinessLogic\Interfaces\Admin\Management\MediaInterface;
use App\BusinessLogic\Interfaces\Admin\Management\CommentInterface;
use App\BusinessLogic\Interfaces\Admin\Management\AppreciationInterface;

// Import application's communication settings
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMessageInterface;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactSubjectInterface;
use App\BusinessLogic\Interfaces\Admin\Communication\NewsletterCampaignInterface;
use App\BusinessLogic\Interfaces\Admin\Communication\NewsletterSubscriberInterface;

// Import application's user settings
use App\BusinessLogic\Interfaces\Admin\Settings\UserInterface;
use App\BusinessLogic\Interfaces\Admin\Settings\RoleInterface;

// Import application's settings
use App\BusinessLogic\Interfaces\Admin\ApplicationSettings\AcceptedDomainInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register application's management settings interfaces and services
        $this->app->bind( ContentInterface::class, ContentService::class );
        $this->app->bind( TagInterface::class, TagService::class );
        $this->app->bind( MediaInterface::class, MediaService::class );
        $this->app->bind( CommentInterface::class, CommentService::class );
        $this->app->bind( AppreciationInterface::class, AppreciationService::class );

        // Register application's communication settings interfaces and services
        $this->app->bind( ContactMessageInterface::class, ContactMessageService::class );
        $this->app->bind( ContactSubjectInterface::class, ContactSubjectService::class );
        $this->app->bind( NewsletterCampaignInterface::class, NewsletterCampaignService::class );
        $this->app->bind( NewsletterSubscriberInterface::class, NewsletterSubscriberService::class );

        // Register application's user settings interfaces and services
        $this->app->bind( UserInterface::class, UserService::class );
        $this->app->bind( RoleInterface::class, RoleService::class );

        // Register application's settings interfaces and services
        $this->app->bind( AcceptedDomainInterface::class, AcceptedDomainService::class );

        // Register laravel telescope
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningUnitTests()) {
            Schema::defaultStringLength(191);
        }
    }
}
