<?php

namespace App\Http\Controllers\Admin\ApplicationSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\ApplicationSettings\AcceptedDomainInterface;
use App\Http\Requests\Admin\ApplicationSettings\AcceptedDomainRequest;

class AcceptedDomainController extends Controller
{
    protected AcceptedDomainInterface $acceptedDomainService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(AcceptedDomainInterface $acceptedDomainService)
    {
        $this->acceptedDomainService = $acceptedDomainService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->acceptedDomainService->handleIndex($request->all());
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  AcceptedDomainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcceptedDomainRequest $request)
    {
        return $this->acceptedDomainService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->acceptedDomainService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  AcceptedDomainRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AcceptedDomainRequest $request, $id)
    {
        return $this->acceptedDomainService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->acceptedDomainService->handleDestroy($id);
    }
}
