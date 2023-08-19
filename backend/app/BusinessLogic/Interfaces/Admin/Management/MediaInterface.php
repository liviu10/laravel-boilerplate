<?php

namespace App\BusinessLogic\Interfaces\Admin\Management;

use App\Http\Requests\Admin\Management\MediaRequest;

/**
 * MediaInterface is a contract for what methods will be used in the MediaService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 * - handleDelete();
 */
interface MediaInterface
{
    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex();

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\MediaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(MediaRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\MediaRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(MediaRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
