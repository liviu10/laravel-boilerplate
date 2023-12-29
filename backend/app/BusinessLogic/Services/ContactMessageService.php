<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\ContactMessageInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\ContactMessage;
use App\Utilities\ApiResponse;
use App\Utilities\ApiCheckPermission;
use App\Utilities\ApiResourcePermission;
use App\Utilities\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactMessageService implements BaseInterface, ContactMessageInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;
    protected $checkPermission;
    protected $resourcePermissions;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new ContactMessage();
        $this->apiResponse = new ApiResponse();
        $this->checkPermission = new ApiCheckPermission();
        $this->resourcePermissions = new ApiResourcePermission();
        $this->handleResourcePermissions();
    }

    /**
     * Handle the index action for displaying a list of records.
     * @param array $search An array of search parameters to filter records.
     * @return Response|ResponseFactory|View The response containing the list of records,
     * a response factory or a view template.
     */
    public function handleIndex(array $search): Response|ResponseFactory|View
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $type = null;
            if ($search && count($search)) {
                if (array_key_exists('type', $search)) {
                    $type = $search['type'];
                    unset($search['type']);
                }
            }

            $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
                $this->modelName->fetchAllRecords($search, $type),
                Actions::get
            );

            if (Request::capture()->expectsJson()) {
                return $apiDisplayAllRecords;
            } else {
                $displayAllRecords = collect($apiDisplayAllRecords->original);
                return view('pages.admin.communication.contact.messages.index', compact('displayAllRecords'));
            }
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
                'full_name'          => $request['full_name'],
                'email'              => $request['email'],
                'phone'              => $request['phone'] ? $request['phone'] : null,
                'contact_subject_id' => $request['contact_subject_id'],
                'message'            => $request['message'],
                'privacy_policy'     => $request['privacy_policy'] !== null ? $request['privacy_policy'] : false,
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
                    'full_name'          => array_key_exists('full_name', $request)
                        ? $request['full_name']
                        : $apiDisplaySingleRecord->toArray()[0]['full_name'],
                    'email'              => array_key_exists('email', $request)
                        ? $request['email']
                        : $apiDisplaySingleRecord->toArray()[0]['email'],
                    'phone'              => array_key_exists('phone', $request)
                        ? $request['phone']
                        : $apiDisplaySingleRecord->toArray()[0]['phone'],
                    'contact_subject_id' => array_key_exists('contact_subject_id', $request)
                        ? $request['contact_subject_id']
                        : $apiDisplaySingleRecord->toArray()[0]['contact_subject_id'],
                    'message'            => array_key_exists('message', $request)
                        ? $request['message']
                        : $apiDisplaySingleRecord->toArray()[0]['message'],
                    'privacy_policy'     => array_key_exists('privacy_policy', $request)
                        ? $request['privacy_policy']
                        : $apiDisplaySingleRecord->toArray()[0]['privacy_policy'],
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

    /**
     * Handle the store action for creating a new record.
     * @param array $request The request data containing information for creating the record.
     * @return Response|ResponseFactory The response containing the created record or a response factory.
     */
    public function handleContactMessage(array $request): Response|ResponseFactory
    {
        $apiInsertRecord = [
            'full_name'          => $request['full_name'],
            'email'              => $request['email'],
            'phone'              => $request['phone'] ? $request['phone'] : null,
            'contact_subject_id' => $request['contact_subject_id'],
            'message'            => $request['message'],
            'privacy_policy'     => $request['privacy_policy'] !== null ? $request['privacy_policy'] : false,
        ];
        $createdRecord = $this->modelName->createRecord($apiInsertRecord);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), Actions::create);

        return $apiCreatedRecord;
    }

    public function handleResourcePermissions(): void
    {
        $resources = $this->modelName->getResources();
        $this->resourcePermissions->handleApiCreateResourcePermission($resources);
    }
}
