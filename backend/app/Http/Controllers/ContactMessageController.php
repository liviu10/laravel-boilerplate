<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\ContactMessageInterface;
use App\Http\Requests\ContactMessageRequest;

class ContactMessageController extends Controller
{
    protected ContactMessageInterface $contactMessageService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(ContactMessageInterface $contactMessageService)
    {
        $this->contactMessageService = $contactMessageService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->contactMessageService->handleIndex($request->all());
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  ContactMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactMessageRequest $request)
    {
        return $this->contactMessageService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->contactMessageService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  ContactMessageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactMessageRequest $request, $id)
    {
        return $this->contactMessageService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->contactMessageService->handleDestroy($id);
    }
}
