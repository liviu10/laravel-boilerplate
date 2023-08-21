<?php

namespace App\BusinessLogic\Interfaces\Admin;

use App\Http\Requests\AcceptedDomainRequest;

/**
 * AcceptedDomainInterface is a contract for what methods will be used in the UserRoleTypeService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 * - handleDelete();
 */
interface AcceptedDomainInterface
{
    /**
     * Fetch all the records from the database.
     * @param array $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search);

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\AcceptedDomainRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(AcceptedDomainRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\AcceptedDomainRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(AcceptedDomainRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
