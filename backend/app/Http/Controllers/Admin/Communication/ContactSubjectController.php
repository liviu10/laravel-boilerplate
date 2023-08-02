<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactSubjectInterface;
use App\Http\Requests\Admin\Communication\ContactSubjectRequest;

class ContactSubjectController extends Controller
{
    protected ContactSubjectInterface $contactSubjectService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(ContactSubjectInterface $contactSubjectService)
    {
        $this->contactSubjectService = $contactSubjectService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->contactSubjectService->handleIndex();
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  ContactSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactSubjectRequest $request)
    {
        return $this->contactSubjectService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->contactSubjectService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  ContactSubjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactSubjectRequest $request, $id)
    {
        return $this->contactSubjectService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->contactSubjectService->handleDestroy($id);
    }
}
