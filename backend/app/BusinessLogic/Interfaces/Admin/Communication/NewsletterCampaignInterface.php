<?php

namespace App\BusinessLogic\Interfaces\Admin\Communication;

use App\Http\Requests\Admin\Communication\NewsletterCampaignRequest;

/**
 * NewsletterCampaignInterface is a contract for what methods will be used in the NewsletterCampaignService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 * - handleDelete();
 */
interface NewsletterCampaignInterface
{
    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex();

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\NewsletterCampaignRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NewsletterCampaignRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\NewsletterCampaignRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(NewsletterCampaignRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
