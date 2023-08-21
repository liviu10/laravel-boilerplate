<?php

namespace App\BusinessLogic\Interfaces\Admin;

use App\Http\Requests\NotificationRequest;

/**
 * NotificationInterface is a contract for what methods will be used in the NotificationService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleUpdate();
 * - handleDelete();
 */
interface NotificationInterface
{
    /**
     * Fetch all the records from the database.
     * @param array $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search);

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\NotificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NotificationRequest $request);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\NotificationRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(NotificationRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
