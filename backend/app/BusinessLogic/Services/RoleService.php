<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\RoleInterface;
use App\Library\ApiResponse;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

/**
 * RoleService is a service class the will implement all the methods from the RoleInterface contract and will handle the business logic.
 */
class RoleService implements RoleInterface
{
    use ApiResponseMessage;

    protected $modelName;
    protected $apiResponse;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Role();
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
     * @param  RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(RoleRequest $request)
    {
        $apiInsertRecord = [
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'bg_color'    => $request->get('bg_color') !== null ? $request->get('bg_color') : null,
            'text_color'  => $request->get('text_color') !== null ? $request->get('text_color') : null,
            'is_active'   => $request->get('is_active'),
        ];
        $apiInsertRecord['slug'] = strtolower($request->get('name'));
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
     * @param  RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(RoleRequest $request, $id)
    {
        $apiUpdateRecord = [
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'bg_color'    => $request->get('bg_color') !== null ? $request->get('bg_color') : null,
            'text_color'  => $request->get('text_color') !== null ? $request->get('text_color') : null,
            'is_active'   => $request->get('is_active'),
        ];
        $apiUpdateRecord['slug'] = strtolower($request->get('name'));
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
