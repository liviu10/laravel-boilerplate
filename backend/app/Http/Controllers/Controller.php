<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $serviceClass;
    protected $requestClass;

    /**
     * Create a new GenericController instance.
     * @param string $serviceClass The fully qualified class name of the service to be used.
     * @param string $requestClass The fully qualified class name of the request to be used for validation.
     * @return void
     */
    public function __construct($serviceClass, $requestClass = null)
    {
        $this->serviceClass = $serviceClass;
        $this->requestClass = $requestClass;
    }

    /**
     * Display a listing of the resource. HTTP request [GET].
     * @param \Illuminate\Http\Request $request The HTTP request instance containing query parameters.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serviceInstance = app($this->serviceClass);

        return $serviceInstance->handleIndex($request->all());
    }

    /**
     * Store a newly created resource in storage. HTTP request [POST].
     * @param \Illuminate\Http\Request $request The HTTP request instance containing the data to be stored.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->requestClass::rules());
        $serviceInstance = app($this->serviceClass);

        return $serviceInstance->handleStore($request->all());
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param int $id The identifier of the resource to be displayed.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serviceInstance = app($this->serviceClass);

        return $serviceInstance->handleShow($id);
    }

    /**
     * Update the specified resource in storage. HTTP request [PUT].
     * @param \Illuminate\Http\Request $request The HTTP request instance containing the updated data.
     * @param int $id The identifier of the resource to be updated.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->requestClass::rules());
        $serviceInstance = app($this->serviceClass);

        return $serviceInstance->handleUpdate($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage. HTTP request [DELETE].
     * @param int $id The identifier of the resource to be removed.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serviceInstance = app($this->serviceClass);

        return $serviceInstance->handleDestroy($id);
    }
}
