<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMeMessageInterface;
use App\Http\Requests\Admin\Communication\ContactMeMessageRequest;

class ContactMeMessageController extends Controller
{
    protected ContactMeMessageInterface $contactMeMessageService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(ContactMeMessageInterface $contactMeMessageService)
    {
        $this->contactMeMessageService = $contactMeMessageService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->contactMeMessageService->handleIndex();
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  ContactMeMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactMeMessageRequest $request)
    {
        return $this->contactMeMessageService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->contactMeMessageService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  ContactMeMessageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactMeMessageRequest $request, $id)
    {
        return $this->contactMeMessageService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->contactMeMessageService->handleDestroy($id);
    }
}
