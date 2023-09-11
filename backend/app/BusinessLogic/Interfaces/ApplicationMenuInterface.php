<?php

namespace App\BusinessLogic\Interfaces;

use App\Http\Requests\ApplicationMenuRequest;

/**
 * ApplicationMenuInterface is a contract for what methods will be used in the ApplicationMenuService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleUpdate();
 */
interface ApplicationMenuInterface
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
     * Update an existing record in the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate($request, $id);
}
