<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMessageInterface;
use App\Http\Requests\Admin\Communication\ContactMessageRequest;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->contactMessageService->handleIndex();
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
