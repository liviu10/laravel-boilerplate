<?php

namespace App\Http\Controllers\Api;

use App\BusinessLogic\Interfaces\NewsletterCampaignInterface;
use App\Http\Requests\NewsletterCampaignRequest;

class NewsletterCampaignController extends Controller
{
    protected NewsletterCampaignInterface $newsletterCampaignService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(NewsletterCampaignInterface::class, NewsletterCampaignRequest::class);
    }
}
