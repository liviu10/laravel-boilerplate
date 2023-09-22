<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\NewsletterCampaignInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\NewsletterCampaign;
use App\Library\ApiResponse;
use App\Library\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class NewsletterCampaignService implements BaseInterface, NewsletterCampaignInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;

    /**
     * Create a new instance of the NewsletterCampaignService.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new NewsletterCampaign();
        $this->apiResponse = new ApiResponse();
    }

    /**
     * Handle the index action for displaying a list of records.
     * @param array $search An array of search parameters to filter records.
     * @return Response|ResponseFactory The response containing the list of records or a response factory.
     */
    public function handleIndex(array $search): Response|ResponseFactory
    {
        $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchAllRecords($search, 'paginate'),
            Actions::get,
            $this->modelName->getFields(),
            class_basename($this->modelName),
            null,
            $this->handleStatisticalIndicators()
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Handle the store action for creating a new record.
     * @param array $request The request data containing information for creating the record.
     * @return Response|ResponseFactory The response containing the created record or a response factory.
     */
    public function handleStore(array $request): Response|ResponseFactory
    {
        $apiInsertRecord = [
            'name'        => $request['name'],
            'description' => $request['description'],
            'is_active'   => $request['is_active'],
            'valid_from'  => $request['valid_from'],
            'valid_to'    => $request['valid_to'],
            'occur_times' => $request['occur_times'],
            'occur_week'  => $request['occur_week'],
            'occur_day'   => $request['occur_day'],
            'occur_hour'  => $request['occur_hour'],
            'user_id'     => Auth::user() ? Auth::user()->id : 1,
        ];
        $createdRecord = $this->modelName->createRecord($apiInsertRecord);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), Actions::create);

        return $apiCreatedRecord;
    }

    /**
     * Handle the show action for displaying a single record.
     * @param int $id The ID of the record to retrieve and display.
     * @return Response|ResponseFactory The response containing the single record or a response factory.
     */
    public function handleShow(int $id): Response|ResponseFactory
    {
        $apiDisplaySingleRecord = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchSingleRecord($id, 'relation'),
            Actions::get
        );

        return $apiDisplaySingleRecord;
    }

    /**
     * Handle the update action for modifying an existing record.
     * @param array $request The request data containing updated information for the record.
     * @param int $id The ID of the record to be updated.
     * @return Response|ResponseFactory The response containing the updated record or a response factory.
     */
    public function handleUpdate(array $request, int $id): Response|ResponseFactory
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
            $apiUpdateRecord = [
                'name'        => $request['name'],
                'description' => $request['description'],
                'is_active'   => $request['is_active'],
                'valid_from'  => $request['valid_from'],
                'valid_to'    => $request['valid_to'],
                'occur_times' => $request['occur_times'],
                'occur_week'  => $request['occur_week'],
                'occur_day'   => $request['occur_day'],
                'occur_hour'  => $request['occur_hour'],
                'user_id'     => Auth::user() ? Auth::user()->id : 1,
            ];
            $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), Actions::update);
        } else {
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse(null, Actions::not_found_record);
        }

        return $apiUpdatedRecord;
    }

    /**
     * Handle the destroy action for deleting a record.
     * @param int $id The ID of the record to be deleted.
     * @return Response|ResponseFactory The response indicating the result of the deletion or a response factory.
     */
    public function handleDestroy(int $id): Response|ResponseFactory
    {
        if (Auth::user() && Auth::user()->role_id === 1) {
            $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
            if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
            }
            $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, Actions::delete);
            return $apiDeleteRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::not_allowed);
        }
    }

    public function handleStatisticalIndicators(): array
    {
        return [];
    }
}
