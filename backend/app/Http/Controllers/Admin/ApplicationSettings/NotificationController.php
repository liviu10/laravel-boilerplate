<?php

namespace App\Http\Controllers\Admin\ApplicationSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\ApplicationSettings\NotificationInterface;
use App\Http\Requests\Admin\ApplicationSettings\NotificationRequest;

class NotificationController extends Controller
{
    protected NotificationInterface $notificationService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(NotificationInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->notificationService->handleIndex($request->all());
    }

    /**
     * Store a new record in the database. HTTP request [POST].
     * @param  NotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        return $this->notificationService->handleStore($request);
    }

    /**
     * Update an existing record in the database. HTTP request [PUT].
     * @param  NotificationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, $id)
    {
        return $this->notificationService->handleUpdate($request, $id);
    }

    /**
     * Delete a single record from the database. HTTP request [DELETE].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->notificationService->handleDestroy($id);
    }
}
