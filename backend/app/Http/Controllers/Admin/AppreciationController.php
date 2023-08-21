<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\AppreciationInterface;
use App\Http\Requests\AppreciationRequest;

class AppreciationController extends Controller
{
    protected AppreciationInterface $appreciationService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(AppreciationInterface $appreciationService)
    {
        $this->appreciationService = $appreciationService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->appreciationService->handleIndex($request->all());
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  AppreciationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppreciationRequest $request)
    {
        return $this->appreciationService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->appreciationService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  AppreciationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppreciationRequest $request, $id)
    {
        return $this->appreciationService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->appreciationService->handleDestroy($id);
    }
}
