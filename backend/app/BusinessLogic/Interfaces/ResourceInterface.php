<?php

namespace App\BusinessLogic\Interfaces;

/**
 * ResourceInterface is a contract for what methods will be used in the ResourceService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleUpdate();
 */
interface ResourceInterface
{
    /**
     * Fetch all the records from the database.
     * @param array $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search);

    /**
     * Store a new record in the database.
     * @return \Illuminate\Http\Response
     */
    public function handleStore($request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate($request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
