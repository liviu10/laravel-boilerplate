<?php

namespace App\BusinessLogic\Services\Admin\Communication;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\Communication\NewsletterSubscriberInterface;
use App\Library\DataModel;
use App\Http\Requests\Admin\Communication\NewsletterSubscriberRequest;
use App\Models\Admin\Communication\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Collection;

/**
 * NewsletterSubscriberService is a service class the will implement all the methods from the NewsletterSubscriberInterface contract and will handle the business logic.
 */
class NewsletterSubscriberService implements NewsletterSubscriberInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new NewsletterSubscriber();
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
     * @param  NewsletterSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NewsletterSubscriberRequest $request)
    {
        $apiInsertRecord = [
            'full_name'              => $request->get('full_name'),
            'email'                  => $request->get('email'),
            'privacy_policy'         => $request->get('privacy_policy') !== null ? $request->get('privacy_policy') : false,
            'valid_email'            => true,
            'newsletter_campaign_id' => 1,
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
     * @param  NewsletterSubscriberRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(NewsletterSubscriberRequest $request, $id)
    {
        $apiUpdateRecord = [
            'full_name'              => $request->get('full_name'),
            'email'                  => $request->get('email'),
            'privacy_policy'         => $request->get('privacy_policy') !== null ? $request->get('privacy_policy') : false,
            'valid_email'            => true,
            'newsletter_campaign_id' => 1,
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
