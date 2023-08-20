<?php

namespace App\BusinessLogic\Services\Admin\ApplicationSettings;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\ApplicationSettings\GeneralInterface;
use App\Library\DataModel;
use App\Http\Requests\Admin\ApplicationSettings\GeneralRequest;
use App\Models\Admin\ApplicationSettings\General;
use Illuminate\Database\Eloquent\Collection;

/**
 * GeneralService is a service class the will implement all the methods from the GeneralInterface contract and will handle the business logic.
 */
class GeneralService implements GeneralInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new General();
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
     * @param  GeneralRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(GeneralRequest $request)
    {
        $apiInsertRecord = [
            'type'    => $request->get('type'),
            'label'   => $request->get('label'),
            'value'   => $request->get('value'),
            'user_id' => 1,
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
     * @param  GeneralRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(GeneralRequest $request, $id)
    {
        $apiUpdateRecord = [
            'type'    => $request->get('type'),
            'label'   => $request->get('label'),
            'value'   => $request->get('value'),
            'user_id' => 1,
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
