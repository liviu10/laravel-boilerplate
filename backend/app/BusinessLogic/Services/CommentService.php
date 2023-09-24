<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\CommentInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\Comment;
use App\Library\ApiResponse;
use App\Library\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class CommentService implements BaseInterface, CommentInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new Comment();
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
            'type'                => $request['type'],
            'status'              => $request['status'],
            'full_name'           => $request['full_name'],
            'email'               => array_key_exists('email', $request)
                ? $request['email']
                : null,
            'message'             => $request['message'],
            'notify_new_comments' => array_key_exists('notify_new_comments', $request)
                ? $request['notify_new_comments']
                : false,
            'content_id'          => $request['content_id'],
            'user_id'             => Auth::user() ? Auth::user()->id : 1,
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
                'type'                => array_key_exists('type', $request)
                    ? $request['type']
                    : $apiDisplaySingleRecord->toArray()[0]['type'],
                'status'              => array_key_exists('status', $request)
                    ? $request['status']
                    : $apiDisplaySingleRecord->toArray()[0]['status'],
                'full_name'           => array_key_exists('full_name', $request)
                    ? $request['full_name']
                    : $apiDisplaySingleRecord->toArray()[0]['full_name'],
                'email'               => array_key_exists('email', $request)
                    ? $request['email']
                    : $apiDisplaySingleRecord->toArray()[0]['email'],
                'message'             => array_key_exists('message', $request)
                    ? $request['message']
                    : $apiDisplaySingleRecord->toArray()[0]['message'],
                'notify_new_comments' => array_key_exists('notify_new_comments', $request)
                    ? $request['notify_new_comments']
                    : $apiDisplaySingleRecord->toArray()[0]['notify_new_comments'],
                'content_id'          => array_key_exists('content_id', $request)
                    ? $request['content_id']
                    : $apiDisplaySingleRecord->toArray()[0]['content_id'],
                'user_id'             => Auth::user() ? Auth::user()->id : 1,
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
