<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\ConfigurationColumnInterface;
use App\Models\ConfigurationColumn;
use App\Utilities\ApiResponse;
use App\Utilities\ApiCheckPermission;
use App\Utilities\ApiResourcePermission;
use App\Utilities\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConfigurationColumnService implements BaseInterface, ConfigurationColumnInterface
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
        $this->modelName = new ConfigurationColumn();
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
                'align' => $request['align'],
                'field' => $request['field'],
                'header_style' => $request['header_style'],
                'label' => $request['label'],
                'name' => $request['name'],
                'position' => $request['position'],
                'style' => $request['style'],
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
                $this->modelName->fetchSingleRecord($id),
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
                    'align' => array_key_exists('align', $request)
                        ? $request['align']
                        : $apiDisplaySingleRecord->toArray()[0]['align'],
                    'field' => array_key_exists('field', $request)
                        ? $request['field']
                        : $apiDisplaySingleRecord->toArray()[0]['field'],
                    'header_style' => array_key_exists('header_style', $request)
                        ? $request['header_style']
                        : $apiDisplaySingleRecord->toArray()[0]['header_style'],
                    'label' => array_key_exists('label', $request)
                        ? $request['label']
                        : $apiDisplaySingleRecord->toArray()[0]['label'],
                    'name' => array_key_exists('name', $request)
                        ? $request['name']
                        : $apiDisplaySingleRecord->toArray()[0]['name'],
                    'position' => array_key_exists('position', $request)
                        ? $request['position']
                        : $apiDisplaySingleRecord->toArray()[0]['position'],
                    'style' => array_key_exists('style', $request)
                        ? $request['style']
                        : $apiDisplaySingleRecord->toArray()[0]['style'],
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
