<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\NewsletterCampaignInterface;
use App\Http\Requests\NewsletterCampaignRequest;

class NewsletterCampaignController extends Controller
{
    protected NewsletterCampaignInterface $newsletterCampaignService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(NewsletterCampaignInterface $newsletterCampaignService)
    {
        $this->newsletterCampaignService = $newsletterCampaignService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->newsletterCampaignService->handleIndex($request->all());
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  NewsletterCampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsletterCampaignRequest $request)
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
     * @param  NewsletterCampaignRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsletterCampaignRequest $request, $id)
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
