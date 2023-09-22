<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\AppreciationInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\Appreciation;
use App\Library\ApiResponse;
use App\Library\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class AppreciationService implements BaseInterface, AppreciationInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;

    /**
     * Create a new instance of the AcceptedDomainService.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new Appreciation();
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
            'likes'      => $request['likes'] ? $request['likes'] : null,
            'dislikes'   => $request['dislikes'] ? $request['dislikes'] : null,
            'rating'     => $request['rating'] ? $request['rating'] : null,
            'content_id' => 1,
            'user_id'    => 1,
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
            'likes'      => $request['likes'] ? $request['likes'] : null,
            'dislikes'   => $request['dislikes'] ? $request['dislikes'] : null,
            'rating'     => $request['rating'] ? $request['rating'] : null,
            'content_id' => 1,
            'user_id'    => 1,
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
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty())
        {
            $this->modelName->deleteRecord($id);
        }
        $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, 'delete');

        return $apiDeleteRecord;
    }

    public function handleStatisticalIndicators(): array
    {
        return [];
    }
}
