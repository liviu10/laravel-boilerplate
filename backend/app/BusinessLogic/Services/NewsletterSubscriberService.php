<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\NewsletterSubscriberInterface;
use App\Library\DataModel;
use App\Http\Requests\NewsletterSubscriberRequest;
use App\Models\AcceptedDomain;
use App\Models\NewsletterSubscriber;
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
     * @param  NewsletterSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(NewsletterSubscriberRequest $request)
    {
        $apiInsertRecord = [
            'full_name' => $request->get('full_name'),
            'email' => $request->get('email'),
            'privacy_policy' => $request->get('privacy_policy') !== null ? $request->get('privacy_policy') : false,
        ];

        $acceptedDomain = new AcceptedDomain();
        $getEmailProvider = explode('.', substr(strstr($request->get('email'), '@'), 1));
        $checkEmailProvider = $acceptedDomain->checkEmailProvider($getEmailProvider);

        if (count($checkEmailProvider) === 2)
        {
            $apiInsertRecord['valid_email'] = true;
            $apiInsertRecord['newsletter_campaign_id'] = 1;
            $saveRecord = $this->modelName->createRecord($apiInsertRecord);
            // TODO: create email WelcomeNewsletter
            if ($saveRecord === true)
            {
                return response($this->handleResponse('success'), 201);
            }
            else
            {
                return response($this->handleResponse('error_message'), 500);
            }
        }
        else
        {
            return response($this->handleResponse('warning'), 422);
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
            'newsletter_campaign_id' => $request->get('newsletter_campaign_id'),
        ];
        $updateRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);

        // TODO: create email updated newsletter campaign

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
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($email)
    {
        $checkEmailSubscriber = $this->modelName->checkEmailSubscriber($email);
        if (count($checkEmailSubscriber))
        {
            $this->modelName->deleteRecord($checkEmailSubscriber[0]['id']);
            return response($this->handleResponse('success'), 200);
        }
        else
        {
            return response($this->handleResponse('not_found'), 200);
        }
    }
}
