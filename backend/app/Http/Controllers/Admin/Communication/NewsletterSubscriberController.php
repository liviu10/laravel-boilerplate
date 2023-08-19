<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Communication\NewsletterSubscriberInterface;
use App\Http\Requests\Admin\Communication\NewsletterSubscriberRequest;

class NewsletterSubscriberController extends Controller
{
    protected NewsletterSubscriberInterface $newsletterCampaignService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(NewsletterSubscriberInterface $newsletterCampaignService)
    {
        $this->newsletterCampaignService = $newsletterCampaignService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->newsletterCampaignService->handleIndex();
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  NewsletterSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsletterSubscriberRequest $request)
    {
        return $this->newsletterCampaignService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->newsletterCampaignService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  NewsletterSubscriberRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsletterSubscriberRequest $request, $id)
    {
        return $this->newsletterCampaignService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->newsletterCampaignService->handleDestroy($id);
    }
}
