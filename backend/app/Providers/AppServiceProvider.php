<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

// Import application's settings
use App\BusinessLogic\Interfaces\AcceptedDomainInterface;
use App\BusinessLogic\Interfaces\GeneralInterface;
use App\BusinessLogic\Interfaces\NotificationInterface;

// Import application's communication settings
use App\BusinessLogic\Interfaces\ContactMessageInterface;
use App\BusinessLogic\Interfaces\ContactSubjectInterface;
use App\BusinessLogic\Interfaces\NewsletterCampaignInterface;
use App\BusinessLogic\Interfaces\NewsletterSubscriberInterface;

// Import application's management settings
use App\BusinessLogic\Interfaces\ContentInterface;
use App\BusinessLogic\Interfaces\TagInterface;
use App\BusinessLogic\Interfaces\MediaInterface;
use App\BusinessLogic\Interfaces\CommentInterface;
use App\BusinessLogic\Interfaces\AppreciationInterface;

// Import application's user settings
use App\BusinessLogic\Interfaces\UserInterface;
use App\BusinessLogic\Interfaces\RoleInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register application's settings interfaces and services
        $this->app->bind( AcceptedDomainInterface::class, AcceptedDomainService::class );
        $this->app->bind( GeneralInterface::class, GeneralService::class );
        $this->app->bind( NotificationInterface::class, NotificationService::class );

        // Register application's communication settings interfaces and services
        $this->app->bind( ContactMessageInterface::class, ContactMessageService::class );
        $this->app->bind( ContactSubjectInterface::class, ContactSubjectService::class );
        $this->app->bind( NewsletterCampaignInterface::class, NewsletterCampaignService::class );
        $this->app->bind( NewsletterSubscriberInterface::class, NewsletterSubscriberService::class );

        // Register application's management settings interfaces and services
        $this->app->bind( AppreciationInterface::class, AppreciationService::class );
        $this->app->bind( CommentInterface::class, CommentService::class );
        $this->app->bind( ContentInterface::class, ContentService::class );
        $this->app->bind( MediaInterface::class, MediaService::class );
        $this->app->bind( TagInterface::class, TagService::class );

        // Register application's user settings interfaces and services
        $this->app->bind( RoleInterface::class, RoleService::class );
        $this->app->bind( UserInterface::class, UserService::class );

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
