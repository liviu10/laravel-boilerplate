<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import application's settings
use App\BusinessLogic\Interfaces\AcceptedDomainInterface;
use App\BusinessLogic\Services\AcceptedDomainService;
use App\BusinessLogic\Interfaces\GeneralInterface;
use App\BusinessLogic\Services\GeneralService;
use App\BusinessLogic\Interfaces\NotificationInterface;
use App\BusinessLogic\Services\NotificationService;

// Import application's communication settings
use App\BusinessLogic\Interfaces\ContactMessageInterface;
use App\BusinessLogic\Services\ContactMessageService;
use App\BusinessLogic\Interfaces\ContactSubjectInterface;
use App\BusinessLogic\Services\ContactSubjectService;
use App\BusinessLogic\Interfaces\NewsletterCampaignInterface;
use App\BusinessLogic\Services\NewsletterCampaignService;
use App\BusinessLogic\Interfaces\NewsletterSubscriberInterface;
use App\BusinessLogic\Services\NewsletterSubscriberService;

// Import application's management settings
use App\BusinessLogic\Interfaces\ContentInterface;
use App\BusinessLogic\Services\ContentService;
use App\BusinessLogic\Interfaces\TagInterface;
use App\BusinessLogic\Services\TagService;
use App\BusinessLogic\Interfaces\MediaInterface;
use App\BusinessLogic\Services\MediaService;
use App\BusinessLogic\Interfaces\CommentInterface;
use App\BusinessLogic\Services\CommentService;
use App\BusinessLogic\Interfaces\AppreciationInterface;
use App\BusinessLogic\Services\AppreciationService;

// Import application's user settings
use App\BusinessLogic\Interfaces\UserInterface;
use App\BusinessLogic\Services\UserService;
use App\BusinessLogic\Interfaces\RoleInterface;
use App\BusinessLogic\Services\RoleService;

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
        $this->app->bind( UserInterface::class, UserService::class );
        $this->app->bind( RoleInterface::class, RoleService::class );
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
