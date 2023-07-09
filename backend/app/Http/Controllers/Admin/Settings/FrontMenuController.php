<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Settings\FrontMenuInterface;
use App\Http\Requests\Admin\Settings\FrontMenuRequest;

class FrontMenuController extends Controller
{
    protected FrontMenuInterface $frontMenuService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(FrontMenuInterface $frontMenuService)
    {
        $this->frontMenuService = $frontMenuService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->frontMenuService->handleIndex();
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  FrontMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FrontMenuRequest $request)
    {
        return $this->frontMenuService->handleStore($request);
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->frontMenuService->handleShow($id);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  FrontMenuRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FrontMenuRequest $request, $id)
    {
        return $this->frontMenuService->handleUpdate($request, $id);
    }
}
