<?php

namespace App\BusinessLogic\Interfaces\Admin;

use App\Http\Requests\NewsletterSubscriberRequest;

/**
 * NewsletterSubscriberInterface is a contract for what methods will be used in the NewsletterSubscriberService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 * - handleDelete();
 */
interface NewsletterSubscriberInterface
{
    /**
     * Fetch all the records from the database.
     * @param array $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search);

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\NewsletterSubscriberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NewsletterSubscriberRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\NewsletterSubscriberRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(NewsletterSubscriberRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
