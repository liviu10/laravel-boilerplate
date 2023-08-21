<?php

namespace App\BusinessLogic\Interfaces\Admin;

use App\Http\Requests\GeneralRequest;

/**
 * GeneralInterface is a contract for what methods will be used in the GeneralService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleUpdate();
 * - handleDelete();
 */
interface GeneralInterface
{
    /**
     * Fetch all the records from the database.
     * @param array $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search);

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\GeneralRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(GeneralRequest $request);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\GeneralRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(GeneralRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
