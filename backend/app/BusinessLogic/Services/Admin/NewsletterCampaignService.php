<?php

namespace App\BusinessLogic\Services\Admin;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\NewsletterCampaignInterface;
use App\Library\DataModel;
use App\Http\Requests\NewsletterCampaignRequest;
use App\Models\Admin\NewsletterCampaign;
use Illuminate\Database\Eloquent\Collection;

/**
 * NewsletterCampaignService is a service class the will implement all the methods from the NewsletterCampaignInterface contract and will handle the business logic.
 */
class NewsletterCampaignService implements NewsletterCampaignInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new NewsletterCampaign();
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
     * @param  NewsletterCampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NewsletterCampaignRequest $request)
    {
        $apiInsertRecord = [
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'is_active'   => $request->get('is_active') !== null ? $request->get('is_active') : false,
            'valid_from'  => $request->get('valid_from'),
            'valid_to'    => $request->get('valid_to'),
            'occur_times' => $request->get('occur_times'),
            'occur_week'  => $request->get('occur_week'),
            'occur_day'   => $request->get('occur_day'),
            'occur_hour'  => $request->get('occur_hour'),
            'user_id'     => 1,
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
     * @param  NewsletterCampaignRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(NewsletterCampaignRequest $request, $id)
    {
        $apiUpdateRecord = [
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'is_active'   => $request->get('is_active') !== null ? $request->get('is_active') : false,
            'valid_from'  => $request->get('valid_from'),
            'valid_to'    => $request->get('valid_to'),
            'occur_times' => $request->get('occur_times'),
            'occur_week'  => $request->get('occur_week'),
            'occur_day'   => $request->get('occur_day'),
            'occur_hour'  => $request->get('occur_hour'),
            'user_id'     => 1,
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
