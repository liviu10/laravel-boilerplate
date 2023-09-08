<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiStatisticalIndicators;
use App\BusinessLogic\Interfaces\CommentInterface;
use App\Library\ApiResponse;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

/**
 * CommentService is a service class the will implement all the methods from the CommentInterface contract and will handle the business logic.
 */
class CommentService implements CommentInterface
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
        $this->modelName = new Comment();
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
            $this->modelName->fetchAllRecords($search, 'paginate'),
            'get',
            $this->modelName->getFields(),
            class_basename($this->modelName)
            [],
            $this->getStatisticalIndicators()
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Store a new record in the database.
     * @param array $request An associative array of values to create a new record.
     * @return \Illuminate\Http\Response
     */
    public function handleStore($request)
    {
        $apiInsertRecord = [
            'type'                => $request['type'],
            'status'              => $request['status'],
            'full_name'           => $request['full_name'],
            'email'               => $request['email'],
            'message'             => $request['message'],
            'notify_new_comments' => $request['notify_new_comments'] !== null ? $request['notify_new_comments'] : false,
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
     * @param array $request An associative array of values to create a new record.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate($request, $id)
    {
        $apiUpdateRecord = [
            'type'                => $request['type'],
            'status'              => $request['status'],
            'full_name'           => $request['full_name'],
            'email'               => $request['email'],
            'message'             => $request['message'],
            'notify_new_comments' => $request['notify_new_comments'] !== null ? $request['notify_new_comments'] : false,
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

    /**
     * Retrieve statistical indicators based on the fetched record details.
     * This function calculates and returns statistical indicators based on the data
     * retrieved using the modelName's `fetchAllRecordDetails` and `getStatisticalIndicators` methods.
     * @return array An associative array containing statistical indicators, where each key represents an indicator name
     * and each value is an associative array with 'number' and 'percentage' keys (depending on the type of indicator).
     */
    public function getStatisticalIndicators()
    {
        // $apiAllRecordDetails = $this->modelName->fetchAllRecords([], 'statistics');
        // $statisticalIndicators = $this->modelName->getStatisticalIndicators();
        // $options = [
        //     'role_id' => $this->modelNameRole->fetchUserRoles()
        // ];

        // return $this->handleStatisticalIndicators(
        //     $apiAllRecordDetails,
        //     $statisticalIndicators,
        //     $options
        // );
    }
}
