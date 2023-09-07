<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiStatisticalIndicators;
use App\BusinessLogic\Interfaces\UserInterface;
use App\Library\ApiResponse;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

/**
 * UserService is a service class the will implement all the methods from the UserInterface contract and will handle the business logic.
 */
class UserService implements UserInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $modelNameRole;
    protected $apiResponse;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
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
        $genericPassword = '!z1{7}2Q%94"';
        $apiInsertRecord = [
            'first_name'    => $request['first_name'],
            'last_name'     => $request['last_name'],
            'nickname'      => $request['nickname'] ?? null,
            'email'         => $request['email'],
            'phone'         => $request['phone'] ?? null,
            'password'      => bcrypt($genericPassword),
            'profile_image' => $request['profile_image'] ?? null,
            'role_id'       => $request['role_id'],
        ];
        $apiInsertRecord['full_name'] = $request['first_name'] . ' ' . $request['last_name'];
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
            'first_name'    => $request['first_name'],
            'last_name'     => $request['last_name'],
            'role_id'       => $request['role_id'],
        ];
        $apiUpdateRecord['full_name'] = $request['first_name'] . ' ' . $request['last_name'];
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

    /**
     * Retrieve statistical indicators based on the fetched record details.
     * This function calculates and returns statistical indicators based on the data
     * retrieved using the modelName's `fetchAllRecordDetails` and `getStatisticalIndicators` methods.
     * @return array An associative array containing statistical indicators, where each key represents an indicator name
     * and each value is an associative array with 'number' and 'percentage' keys (depending on the type of indicator).
     */
    public function getStatisticalIndicators()
    {
        $apiAllRecordDetails = $this->modelName->fetchAllRecords([], 'statistics');
        $statisticalIndicators = $this->modelName->getStatisticalIndicators();
        $options = [
            'role_id' => $this->modelNameRole->fetchUserRoles()
        ];

        return $this->handleStatisticalIndicators(
            $apiAllRecordDetails,
            $statisticalIndicators,
            $options
        );
    }
}
