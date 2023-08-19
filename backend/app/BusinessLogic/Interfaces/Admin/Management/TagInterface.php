<?php

namespace App\BusinessLogic\Interfaces\Admin\Management;

use App\Http\Requests\Admin\Management\TagRequest;

/**
 * TagInterface is a contract for what methods will be used in the TagService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 * - handleDelete();
 */
interface TagInterface
{
    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex();

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\TagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(TagRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\TagRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(TagRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
