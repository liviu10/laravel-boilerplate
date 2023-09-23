<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\RoleInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\Role;
use App\Library\ApiResponse;
use App\Library\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class RoleService implements BaseInterface, RoleInterface
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
        $this->modelName = new Role();
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
            [],
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
            'bg_color'    => array_key_exists('bg_color', $request)
                ? $request['bg_color']
                : null,
            'text_color'  => array_key_exists('text_color', $request)
                ? $request['text_color']
                : null,
            'is_active'   => $request['is_active'],
        ];
        $apiInsertRecord['slug'] = strtolower($request['name']);
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
                'name'        => array_key_exists('name', $request)
                    ? $request['name']
                    : $apiDisplaySingleRecord->toArray()[0]['name'],
                'description' => array_key_exists('description', $request)
                    ? $request['description']
                    : $apiDisplaySingleRecord->toArray()[0]['description'],
                'bg_color'    => array_key_exists('bg_color', $request)
                    ? $request['bg_color']
                    : $apiDisplaySingleRecord->toArray()[0]['bg_color'],
                'text_color'  => array_key_exists('text_color', $request)
                    ? $request['text_color']
                    : $apiDisplaySingleRecord->toArray()[0]['text_color'],
                'is_active'   => array_key_exists('is_active', $request)
                    ? $request['is_active']
                    : $apiDisplaySingleRecord->toArray()[0]['is_active'],
            ];
            $apiUpdateRecord['slug'] = strtolower($request['name']);
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
