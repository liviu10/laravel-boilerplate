<?php

namespace App\BusinessLogic\Services\Admin\Communication;

use App\Traits\ApiResponseMessage;
use App\Traits\GenerateDataModel;
use App\Traits\GenerateFilterModel;
use App\BusinessLogic\Interfaces\Admin\Communication\ContactMessageInterface;
use App\Http\Requests\Admin\Communication\ContactMessageRequest;
use App\Models\Admin\Communication\ContactMessage;
use Illuminate\Database\Eloquent\Collection;

/**
 * ContactMessageService is a service class the will implement all the methods from the ContactMessageInterface contract and will handle the business logic.
 */
class ContactMessageService implements ContactMessageInterface
{
    use ApiResponseMessage, GenerateDataModel, GenerateFilterModel;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new ContactMessage();
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
                $apiDataModel = $this->generateApiDataModel($this->modelName->getFields());
                $apiFilterModel = $this->generateApiFilterModel($apiDisplayAllRecords->toArray(), $this->modelName->getFields());

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
     * @param  ContactMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(ContactMessageRequest $request)
    {
        $apiInsertRecord = [
            'full_name'          => $request->get('full_name'),
            'email'              => $request->get('email'),
            'phone'              => $request->get('phone') !== null ? $request->get('phone') : null,
            'contact_subject_id' => $request->get('contact_subject_id'),
            'message'            => $request->get('message'),
            'privacy_policy'     => $request->get('privacy_policy') !== null ? $request->get('privacy_policy') : false,
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
     * @param  ContactMessageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(ContactMessageRequest $request, $id)
    {
        $apiUpdateRecord = [
            'full_name'          => $request->get('full_name'),
            'email'              => $request->get('email'),
            'phone'              => $request->get('phone') !== null ? $request->get('phone') : null,
            'contact_subject_id' => $request->get('contact_subject_id'),
            'message'            => $request->get('message'),
            'privacy_policy'     => $request->get('privacy_policy') !== null ? $request->get('privacy_policy') : false,
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
