<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\AcceptedDomainInterface;
use Illuminate\Support\Facades\Auth;
use App\Library\ApiResponse;
use App\Http\Requests\AcceptedDomainRequest;
use App\Models\AcceptedDomain;
use Illuminate\Database\Eloquent\Collection;

/**
 * AcceptedDomainService is a service class the will implement all the methods from the AcceptedDomainInterface contract and will handle the business logic.
 */
class AcceptedDomainService implements AcceptedDomainInterface
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
        $this->modelName = new AcceptedDomain();
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
            $this->modelName->getUniqueDomainTypes(),
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
            'domain'    => '.' . $request['domain'],
            'type'      => $request['type'],
            'user_id'   => Auth::user() ? Auth::user()->id : 1,
            'is_active' => $request['is_active'],
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
            'domain'    => $request['domain'],
            'type'      => $request['type'],
            'user_id'   => Auth::user() ? Auth::user()->id : 1,
            'is_active' => $request['is_active'],
        ];
        $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), 'update');

        return $apiCreatedRecord;
    }

    /**
     * Delete a single record from the database
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty())
        {
            $this->modelName->deleteRecord($id);
        }
        $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, 'delete');
        return $apiDeleteRecord;
    }

    public function getStatisticalIndicators()
    {
        $apiAllRecordDetails = $this->modelName->fetchAllRecordDetails();
        $types = $this->modelName->getUniqueDomainTypes()['type'];

        $numberOfRecords = count($apiAllRecordDetails);
        $typeOptions = [];
        $numberOfActiveRecords = 0;
        $numberOfInactiveRecords = 0;

        foreach ($apiAllRecordDetails as $item) {
            if ($item['type']) {
                foreach ($types as $type) {
                    $typeOptions += [
                        (string)$type['type'] => []
                    ];
                    $typeCount = 0;
                    foreach ($apiAllRecordDetails as $innerItem) {
                        $innerItem['type'] === $type['type'] ? $typeCount++ : null;
                    }
                    $typeOptions[(string)$type['type']]['number'] = $typeCount;
                    $typeOptions[(string)$type['type']]['percentage'] = round(($typeCount / $numberOfRecords) * 100, 2);
                }
            }

            $item['is_active'] ? $numberOfActiveRecords++ : $numberOfInactiveRecords++;
        }

        $indicators = [
            'number_of_accepted_domains' => [
                'number'     => $numberOfRecords,
                'percentage' => null,
            ],
            'number_of_accepted_domains_by_type' => $typeOptions,
            'number_of_accepted_domains_by_status' => [
                'active' => [
                    'number'     => $numberOfActiveRecords,
                    'percentage' => null,
                ],
                'inactive' => [
                    'number'     => $numberOfInactiveRecords,
                    'percentage' => null,
                ],
            ],
        ];

        return $indicators;
    }
}
