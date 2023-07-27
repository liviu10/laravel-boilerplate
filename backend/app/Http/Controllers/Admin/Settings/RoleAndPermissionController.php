<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Settings\RoleAndPermissionInterface;
use App\Http\Requests\Admin\Settings\RoleAndPermissionRequest;

class RoleAndPermissionController extends Controller
{
    protected RoleAndPermissionInterface $roleAndPermissionService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(RoleAndPermissionInterface $roleAndPermissionService)
    {
        $this->roleAndPermissionService = $roleAndPermissionService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->roleAndPermissionService->handleIndex();
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  RoleAndPermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleAndPermissionRequest $request)
    {
        return $this->roleAndPermissionService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->roleAndPermissionService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  RoleAndPermissionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleAndPermissionRequest $request, $id)
    {
        return $this->roleAndPermissionService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->roleAndPermissionService->handleDestroy($id);
    }
}
