<?php

namespace App\BusinessLogic\Services\Admin\ApplicationSettings;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\ApplicationSettings\AcceptedDomainInterface;
use App\BusinessLogic\Services\Admin\DataModel;
use App\Http\Requests\Admin\ApplicationSettings\AcceptedDomainRequest;
use App\Models\Admin\ApplicationSettings\AcceptedDomain;
use Illuminate\Database\Eloquent\Collection;

/**
 * AcceptedDomainService is a service class the will implement all the methods from the AcceptedDomainInterface contract and will handle the business logic.
 */
class AcceptedDomainService implements AcceptedDomainInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new AcceptedDomain();
    }

    /**
     * Fetch all the records from the database.
     * @param  array  $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search)
    {
        $apiDisplayAllRecords = $this->modelName->fetchAllRecords($search);

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
     * @param  AcceptedDomainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(AcceptedDomainRequest $request)
    {
        $apiInsertRecord = [
            'domain'    => substr($request->get('domain'), 0) === '.' ? $request->get('domain') : '.' . $request->get('domain'),
            'type'      => $request->get('type'),
            'user_id'   => $request->get('user_id'),
            'is_active' => $request->get('is_active'),
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
     * @param  AcceptedDomainRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(AcceptedDomainRequest $request, $id)
    {
        $apiUpdateRecord = [
            'domain'    => substr($request->get('domain'), 0) === '.' ? $request->get('domain') : '.' . $request->get('domain'),
            'type'      => $request->get('type'),
            'user_id'   => $request->get('user_id'),
            'is_active' => $request->get('is_active'),
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
