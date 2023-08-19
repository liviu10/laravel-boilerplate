<?php

namespace App\BusinessLogic\Services\Admin\Management;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\Management\CommentInterface;
use App\Library\DataModel;
use App\Http\Requests\Admin\Management\CommentRequest;
use App\Models\Admin\Management\Comment;
use Illuminate\Database\Eloquent\Collection;

/**
 * CommentService is a service class the will implement all the methods from the CommentInterface contract and will handle the business logic.
 */
class CommentService implements CommentInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Comment();
    }

    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex()
    {
        $apiDisplayAllRecords = $this->modelName->fetchAllRecords();

        if ($apiDisplayAllRecords instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {
            if ($apiDisplayAllRecords->isEmpty())
            {
                return response($this->handleResponse('not_found'), 200);
            }
            else
            {
                $dataModel = new DataModel($apiDisplayAllRecords->toArray(), $this->modelName->getFields(), class_basename($this->modelName));
                $apiDataModel = $dataModel->generateDataModel('model');
                $apiColumnModel = $dataModel->generateDataModel('column');
                $apiFilterModel = $dataModel->generateDataModel('filter');

                return response($this->handleResponse('success',
                    $apiDisplayAllRecords,
                    $apiDataModel,
                    $apiColumnModel,
                    $apiFilterModel
                ), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Store a new record in the database.
     * @param  CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(CommentRequest $request)
    {
        $apiInsertRecord = [
            'type'                => $request->get('type'),
            'status'              => $request->get('status'),
            'full_name'           => $request->get('full_name'),
            'email'               => $request->get('email'),
            'message'             => $request->get('message'),
            'notify_new_comments' => $request->get('notify_new_comments') !== null ? $request->get('notify_new_comments') : false,
            'content_id'          => 1,
            'user_id'             => 1,
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
     * Fetch a single record from the database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id)
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
                return response($this->handleResponse('success', $apiDisplaySingleRecord), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  CommentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(CommentRequest $request, $id)
    {
        $apiUpdateRecord = [
            'type'                => $request->get('type'),
            'status'              => $request->get('status'),
            'full_name'           => $request->get('full_name'),
            'email'               => $request->get('email'),
            'message'             => $request->get('message'),
            'notify_new_comments' => $request->get('notify_new_comments') !== null ? $request->get('notify_new_comments') : false,
            'content_id'          => 1,
            'user_id'             => 1,
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
