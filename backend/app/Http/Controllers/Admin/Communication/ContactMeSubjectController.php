<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMeSubjectInterface;
use App\Http\Requests\Admin\Communication\ContactMeSubjectRequest;

class ContactMeSubjectController extends Controller
{
    protected ContactMeSubjectInterface $contactMeSubjectService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(ContactMeSubjectInterface $contactMeSubjectService)
    {
        $this->contactMeSubjectService = $contactMeSubjectService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->contactMeSubjectService->handleIndex();
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  ContactMeSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactMeSubjectRequest $request)
    {
        return $this->contactMeSubjectService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->contactMeSubjectService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  ContactMeSubjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactMeSubjectRequest $request, $id)
    {
        return $this->contactMeSubjectService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->contactMeSubjectService->handleDestroy($id);
    }
}
