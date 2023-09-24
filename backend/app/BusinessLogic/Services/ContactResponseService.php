<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\ContactResponseInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\ContactResponse;
use App\Utilities\ApiResponse;
use App\Utilities\ApiCheckPermission;
use App\Utilities\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class ContactResponseService implements BaseInterface, ContactResponseInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;
    protected $checkPermission;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new ContactResponse();
        $this->apiResponse = new ApiResponse();
        $this->checkPermission = new ApiCheckPermission();
    }

    /**
     * Handle the index action for displaying a list of records.
     * @param array $search An array of search parameters to filter records.
     * @return Response|ResponseFactory The response containing the list of records or a response factory.
     */
    public function handleIndex(array $search): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
                $this->modelName->fetchAllRecords($search, 'paginate'),
                Actions::get,
                $this->modelName->getFields(),
                class_basename($this->modelName),
                null,
                $this->handleStatisticalIndicators()
            );

            return $apiDisplayAllRecords;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }

    /**
     * Handle the store action for creating a new record.
     * @param array $request The request data containing information for creating the record.
     * @return Response|ResponseFactory The response containing the created record or a response factory.
     */
    public function handleStore(array $request): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $apiInsertRecord = [
                'contact_message_id' => $request['contact_message_id'],
                'message'            => $request['message'],
                'user_id'            => Auth::user() ? Auth::user()->id : 1,
            ];
            $createdRecord = $this->modelName->createRecord($apiInsertRecord);
            $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), Actions::create);

            return $apiCreatedRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }

    /**
     * Handle the show action for displaying a single record.
     * @param int $id The ID of the record to retrieve and display.
     * @return Response|ResponseFactory The response containing the single record or a response factory.
     */
    public function handleShow(int $id): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $apiDisplaySingleRecord = $this->apiResponse->generateApiResponse(
                $this->modelName->fetchSingleRecord($id, 'relation'),
                Actions::get
            );

            return $apiDisplaySingleRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }

    /**
     * Handle the update action for modifying an existing record.
     * @param array $request The request data containing updated information for the record.
     * @param int $id The ID of the record to be updated.
     * @return Response|ResponseFactory The response containing the updated record or a response factory.
     */
    public function handleUpdate(array $request, int $id): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
            if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
                $apiUpdateRecord = [
                    'contact_message_id' => array_key_exists('contact_message_id', $request)
                        ? $request['contact_message_id']
                        : $apiDisplaySingleRecord->toArray()[0]['contact_message_id'],
                    'message'            => array_key_exists('message', $request)
                        ? $request['message']
                        : $apiDisplaySingleRecord->toArray()[0]['message'],
                    'user_id'            => Auth::user() ? Auth::user()->id : 1,
                ];
                $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
                $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), Actions::update);
            } else {
                $apiUpdatedRecord = $this->apiResponse->generateApiResponse(null, Actions::not_found_record);
            }

            return $apiUpdatedRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }

    /**
     * Handle the destroy action for deleting a record.
     * @param int $id The ID of the record to be deleted.
     * @return Response|ResponseFactory The response indicating the result of the deletion or a response factory.
     */
    public function handleDestroy(int $id): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
            if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
            }
            $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, Actions::delete);

            return $apiDeleteRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }

    public function handleStatisticalIndicators(): array
    {
        return [];
    }
}
