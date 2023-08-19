<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import application's management settings
use App\BusinessLogic\Interfaces\Admin\Management\ContentInterface;
use App\BusinessLogic\Services\Admin\Management\ContentService;
use App\BusinessLogic\Interfaces\Admin\Management\TagInterface;
use App\BusinessLogic\Services\Admin\Management\TagService;
use App\BusinessLogic\Interfaces\Admin\Management\MediaInterface;
use App\BusinessLogic\Services\Admin\Management\MediaService;
use App\BusinessLogic\Interfaces\Admin\Management\CommentInterface;
use App\BusinessLogic\Services\Admin\Management\CommentService;
use App\BusinessLogic\Interfaces\Admin\Management\AppreciationInterface;
use App\BusinessLogic\Services\Admin\Management\AppreciationService;

// Import application's communication settings
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMessageInterface;
use App\BusinessLogic\Services\Admin\Communication\ContactMessageService;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactSubjectInterface;
use App\BusinessLogic\Services\Admin\Communication\ContactSubjectService;
use App\BusinessLogic\Interfaces\Admin\Communication\NewsletterCampaignInterface;
use App\BusinessLogic\Services\Admin\Communication\NewsletterCampaignService;
use App\BusinessLogic\Interfaces\Admin\Communication\NewsletterSubscriberInterface;
use App\BusinessLogic\Services\Admin\Communication\NewsletterSubscriberService;

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
