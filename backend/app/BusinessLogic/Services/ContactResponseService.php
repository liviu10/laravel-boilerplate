<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiStatisticalIndicators;
use App\BusinessLogic\Interfaces\ContactResponseInterface;
use Illuminate\Support\Facades\Auth;
use App\Library\ApiResponse;
use App\Models\ContactResponse;
use Illuminate\Database\Eloquent\Collection;

/**
 * ContactResponseService is a service class the will implement all the methods from the ContactResponseInterface contract and will handle the business logic.
 */
class ContactResponseService implements ContactResponseInterface
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
        $this->modelName = new ContactResponse();
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
            class_basename($this->modelName),
            null,
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
            'full_name'          => $request['full_name'],
            'email'              => $request['email'],
            'contact_message_id' => $request['contact_message_id'],
            'message'            => $request['message'],
            'user_id'            => Auth::user() ? Auth::user()->id : 1,
        ];
        $createdRecord = $this->modelName->createRecord($apiInsertRecord);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), 'create');

        return $apiCreatedRecord;
    }

    /**
     * Fetch a single record from the database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id)
    {
        $apiDisplaySingleRecord = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchSingleRecord($id, 'relation'),
            'get'
        );

        return $apiDisplaySingleRecord;
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
            'full_name'          => $request['full_name'],
            'email'              => $request['email'],
            'contact_message_id' => $request['contact_message_id'],
            'message'            => $request['message'],
            'user_id'            => Auth::user() ? Auth::user()->id : 1,
        ];
        $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
        $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), 'update');

        return $apiUpdatedRecord;
    }

    /**
     * Delete a single record from the database
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id)
    {
        if (Auth::user() && Auth::user()->role_id === 1) {
            $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
            if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
            }
            $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, 'delete');
            return $apiDeleteRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, 'not_allowed');
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
        //
    }
}
