<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\UserInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\User;
use App\Models\Role;
use App\Library\ApiResponse;
use App\Library\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class UserService implements BaseInterface, UserInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $modelNameRole;
    protected $apiResponse;

    /**
     * Create a new instance of the AcceptedDomainService.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new User();
        $this->modelNameRole = new Role();
        $this->apiResponse = new ApiResponse();
    }

    /**
     * Fetch current authenticate user from the database.
     * @return \Illuminate\Http\Response
     */
    // TODO: Improve this when finishing with the login system
    // public function handleCurrentAuthUser()
    // {
    //     $apiDisplayAllRecords = $this->modelName->currentAuthUser();

    //     if ($apiDisplayAllRecords instanceof \Illuminate\Pagination\LengthAwarePaginator)
    //     {
    //         if ($apiDisplayAllRecords->isEmpty())
    //         {
    //             return response($this->handleResponse('not_found'), 404);
    //         }
    //         else
    //         {
    //             return response($this->handleResponse('success', $apiDisplayAllRecords), 200);
    //         }
    //     }
    //     else
    //     {
    //         return response($this->handleResponse('error_message'), 500);
    //     }
    // }

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
        $genericPassword = '!z1{7}2Q%94"';
        $apiInsertRecord = [
            'first_name'    => $request['first_name'],
            'last_name'     => $request['last_name'],
            'nickname'      => $request['nickname'] ?? null,
            'email'         => $request['email'],
            'phone'         => $request['phone'] ?? null,
            'password'      => bcrypt($genericPassword),
            'profile_image' => $request['profile_image'] ?? null,
            'role_id'       => $request['role_id'] ?? 5,
        ];
        $apiInsertRecord['full_name'] = $request['first_name'] . ' ' . $request['last_name'];
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
                'first_name' => $request['first_name'] ?? $apiDisplaySingleRecord->full_name,
                'last_name' => $request['last_name'] ?? $apiDisplaySingleRecord->last_name,
                'role_id' => $request['role_id'] ?? $apiDisplaySingleRecord->role_id,
            ];
            $apiUpdateRecord['full_name'] = $request['first_name'] . ' ' . $request['last_name'];
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
        // $apiAllRecordDetails = $this->modelName->fetchAllRecords([], 'statistics');
        // $statisticalIndicators = $this->modelName->getStatisticalIndicators();
        // $options = [
        //     'role_id' => $this->modelNameRole->fetchUserRoles()
        // ];

        // return $this->handleStatisticalIndicators(
        //     $apiAllRecordDetails,
        //     $statisticalIndicators,
        //     $options
        // );

        return [];
    }
}
