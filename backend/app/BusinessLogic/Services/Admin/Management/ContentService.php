<?php

namespace App\BusinessLogic\Services\Admin\Management;

use App\Traits\ApiResponseMessage;
use App\Traits\GenerateDataModel;
use App\Traits\GenerateFilterModel;
use App\BusinessLogic\Interfaces\Admin\Management\ContentInterface;
use App\Http\Requests\Admin\Management\ContentRequest;
use App\Models\Admin\Management\Content;
use Illuminate\Database\Eloquent\Collection;

/**
 * ContentService is a service class the will implement all the methods from the ContentInterface contract and will handle the business logic.
 */
class ContentService implements ContentInterface
{
    use ApiResponseMessage, GenerateDataModel, GenerateFilterModel;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Content();
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
                $modelOptions = [
                    'visibility'   => $this->modelName->getVisibilityOptions(),
                    'content_type' => $this->modelName->getContentTypeOptions(),
                ];
                $apiDataModel = $this->generateApiDataModel($this->modelName->getFields(), $modelOptions);
                $apiFilterModel = $this->generateApiFilterModel($apiDisplayAllRecords->toArray(), $this->modelName->getFields(), $modelOptions);

                return response($this->handleResponse('success', $apiDisplayAllRecords, $apiDataModel, $apiFilterModel), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Store a new record in the database.
     * @param  ContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(ContentRequest $request)
    {
        $apiInsertRecord = [
            'visibility'     => $request->get('visibility'),
            'content_url'    => $request->get('content_url'),
            'title'          => $request->get('title'),
            'content_type'   => $request->get('content_type'),
            'description'    => $request->get('description'),
            'content'        => $request->get('content'),
            'allow_comments' => $request->get('allow_comments') !== null ? $request->get('allow_comments') : false,
            'user_id'        => 1,
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
     * @param  ContentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(ContentRequest $request, $id)
    {
        $apiUpdateRecord = [
            'visibility'     => $request->get('visibility'),
            'content_url'    => $request->get('content_url'),
            'title'          => $request->get('title'),
            'content_type'   => $request->get('content_type'),
            'description'    => $request->get('description'),
            'content'        => $request->get('content'),
            'allow_comments' => $request->get('allow_comments') !== null ? $request->get('allow_comments') : false,
            'user_id'        => 1,
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
