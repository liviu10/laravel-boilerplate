<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\ConfigurationInputInterface;
use App\Models\ConfigurationInput;
use App\Utilities\ApiResponse;
use App\Utilities\ApiCheckPermission;
use App\Utilities\ApiResourcePermission;
use App\Utilities\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConfigurationInputService implements BaseInterface, ConfigurationInputInterface
{
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
        $this->modelName = new ConfigurationInput();
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
                return view('pages.admin.settings.configuration-resources.index', compact('displayAllRecords'));
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
                'accept' => array_key_exists('accepted', $request)
                    ? $request['accepted']
                    : null,
                'field' => $request['field'],
                'is_active' => array_key_exists('is_active', $request)
                    ? $request['is_active']
                    : false,
                'is_filter' => array_key_exists('is_filter', $request)
                    ? $request['is_filter']
                    : false,
                'is_model' => array_key_exists('is_model', $request)
                    ? $request['is_model']
                    : false,
                'key' => $request['key'],
                'name' => $request['name'],
                'position' => $request['position'],
                'type' => $request['type'],
                'configuration_resource_id' => $request['configuration_resource_id'],
                'configuration_type_id' => $request['configuration_type_id'],
                // 'user_id'   => Auth::user() ? Auth::user()->id : 1,
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
                $this->modelName->fetchConfigurationInputs($id),
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
                    'accept' => array_key_exists('accept', $request)
                        ? $request['accept']
                        : $apiDisplaySingleRecord->toArray()[0]['accept'],
                    'field' => array_key_exists('field', $request)
                        ? $request['field']
                        : $apiDisplaySingleRecord->toArray()[0]['field'],
                    'is_active' => array_key_exists('is_active', $request)
                        ? $request['is_active']
                        : $apiDisplaySingleRecord->toArray()[0]['is_active'],
                    'is_filter' => array_key_exists('is_filter', $request)
                        ? $request['is_filter']
                        : $apiDisplaySingleRecord->toArray()[0]['is_filter'],
                    'is_model' => array_key_exists('is_model', $request)
                        ? $request['is_model']
                        : $apiDisplaySingleRecord->toArray()[0]['is_model'],
                    'key' => array_key_exists('key', $request)
                        ? $request['key']
                        : $apiDisplaySingleRecord->toArray()[0]['key'],
                    'name' => array_key_exists('name', $request)
                        ? $request['name']
                        : $apiDisplaySingleRecord->toArray()[0]['name'],
                    'position' => array_key_exists('position', $request)
                        ? $request['position']
                        : $apiDisplaySingleRecord->toArray()[0]['position'],
                    'type' => array_key_exists('type', $request)
                        ? $request['type']
                        : $apiDisplaySingleRecord->toArray()[0]['type'],
                    'configuration_resource_id' => array_key_exists('configuration_resource_id', $request)
                        ? $request['configuration_resource_id']
                        : $apiDisplaySingleRecord->toArray()[0]['configuration_resource_id'],
                    'configuration_type_id' => array_key_exists('configuration_type_id', $request)
                        ? $request['configuration_type_id']
                        : $apiDisplaySingleRecord->toArray()[0]['configuration_type_id'],
                    // 'user_id' => Auth::user() ? Auth::user()->id : 1,
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

    public function handleResourcePermissions(): void
    {
        $resources = $this->modelName->getResources();
        $this->resourcePermissions->handleApiCreateResourcePermission($resources);
    }
}
