<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiStatisticalIndicators;
use App\BusinessLogic\Interfaces\NotificationInterface;
use App\Library\ApiResponse;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

/**
 * NotificationService is a service class the will implement all the methods from the NotificationInterface contract and will handle the business logic.
 */
class NotificationService implements NotificationInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Notification();
        $this->apiResponse = new ApiResponse();
    }

    /**
     * Fetch all the records from the database.
     * @param  array  $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search)
    {
        $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchAllRecords($search),
            $this->modelName->getFields(),
            class_basename($this->modelName)
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Store a new record in the database.
     * @param  NotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NotificationRequest $request)
    {
        $apiInsertRecord = [
            'type'      => $request->get('type'),
            'condition' => $request->get('condition'),
            'title'     => $request->get('title'),
            'content'   => $request->get('content'),
            'user_id'   => 1,
        ];
        $saveRecord = $this->modelName->createRecord($apiInsertRecord);

        if ($saveRecord === true)
        {
            return response($this->handleResponse('success'), 201);
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  NotificationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(NotificationRequest $request, $id)
    {
        $apiUpdateRecord = [
            'type'      => $request->get('type'),
            'condition' => $request->get('condition'),
            'title'     => $request->get('title'),
            'content'   => $request->get('content'),
            'user_id'   => 1,
        ];
        $updateRecord = $this->modelName->createRecord($apiUpdateRecord, $id);

        if ($updateRecord === true)
        {
            return response($this->handleResponse('success'), 201);
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Delete a single record from the database
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);

        if ($apiDisplaySingleRecord instanceof Collection)
        {
            if ($apiDisplaySingleRecord->isEmpty())
            {
                return response($this->handleResponse('not_found'), 404);
            }
            else
            {
                $this->modelName->deleteRecord($id);
                return response($this->handleResponse('success'), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }
}
