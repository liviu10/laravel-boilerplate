<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import application's settings
use App\BusinessLogic\Interfaces\Admin\AcceptedDomainInterface;
use App\BusinessLogic\Services\Admin\AcceptedDomainService;
use App\BusinessLogic\Interfaces\Admin\GeneralInterface;
use App\BusinessLogic\Services\Admin\GeneralService;
use App\BusinessLogic\Interfaces\Admin\NotificationInterface;
use App\BusinessLogic\Services\Admin\NotificationService;

// Import application's communication settings
use App\BusinessLogic\Interfaces\Admin\ContactMessageInterface;
use App\BusinessLogic\Services\Admin\ContactMessageService;
use App\BusinessLogic\Interfaces\Admin\ContactSubjectInterface;
use App\BusinessLogic\Services\Admin\ContactSubjectService;
use App\BusinessLogic\Interfaces\Admin\NewsletterCampaignInterface;
use App\BusinessLogic\Services\Admin\NewsletterCampaignService;
use App\BusinessLogic\Interfaces\Admin\NewsletterSubscriberInterface;
use App\BusinessLogic\Services\Admin\NewsletterSubscriberService;

// Import application's management settings
use App\BusinessLogic\Interfaces\Admin\ContentInterface;
use App\BusinessLogic\Services\Admin\ContentService;
use App\BusinessLogic\Interfaces\Admin\TagInterface;
use App\BusinessLogic\Services\Admin\TagService;
use App\BusinessLogic\Interfaces\Admin\MediaInterface;
use App\BusinessLogic\Services\Admin\MediaService;
use App\BusinessLogic\Interfaces\Admin\CommentInterface;
use App\BusinessLogic\Services\Admin\CommentService;
use App\BusinessLogic\Interfaces\Admin\AppreciationInterface;
use App\BusinessLogic\Services\Admin\AppreciationService;

// Import application's report settings
use App\BusinessLogic\Interfaces\Admin\ReportInterface;
use App\BusinessLogic\Services\Admin\ReportService;

// Import application's user settings
use App\BusinessLogic\Interfaces\Admin\UserInterface;
use App\BusinessLogic\Services\Admin\UserService;
use App\BusinessLogic\Interfaces\Admin\RoleInterface;
use App\BusinessLogic\Services\Admin\RoleService;

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

        // Register application's report settings interfaces and services
        $this->app->bind( ReportInterface::class, ReportService::class );

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
