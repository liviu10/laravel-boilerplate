<?php

namespace App\BusinessLogic\Interfaces\Admin\Settings;

use App\Http\Requests\Admin\Settings\FrontMenuRequest;

/**
 * FrontMenuInterface is a contract for what methods will be used in the FrontMenuService class.
 * This consists of the following CRUD operations methods:
 * - handleIndex();
 * - handleStore();
 * - handleShow();
 * - handleUpdate();
 */
interface FrontMenuInterface
{
    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex();

    /**
     * Store a new record in the database.
     * @param App\Http\Requests\Admin\FrontMenuRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(FrontMenuRequest $request);

    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);

    /**
     * Update an existing record in the database.
     * @param App\Http\Requests\Admin\FrontMenuRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(FrontMenuRequest $request, $id);
}
