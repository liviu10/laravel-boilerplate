<?php

namespace App\BusinessLogic\Interfaces\Admin\Settings;

use App\Http\Requests\Admin\Settings\UserRequest;

/**
 * UserInterface is a contract for what methods will be used in the UserService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 * - handleOrderTableColumn();
 * - handleFilterTableColumn();
 */
interface UserInterface
{
    /**
     * Fetch current authenticated user.
     * @return \Illuminate\Http\Response
     */
    public function handleFetchCurrentAuthUser();

    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex();

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(UserRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(UserRequest $request, $id);

    /**
     * Delete a single record from the database
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id);
}
