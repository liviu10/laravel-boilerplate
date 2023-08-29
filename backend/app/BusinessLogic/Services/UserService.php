<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\UserInterface;
use App\Library\ApiResponse;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * UserService is a service class the will implement all the methods from the UserInterface contract and will handle the business logic.
 */
class UserService implements UserInterface
{
    use ApiResponseMessage;

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
    public function handleCurrentAuthUser()
    {
        $apiDisplayAllRecords = $this->modelName->currentAuthUser();

        if ($apiDisplayAllRecords instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {
            if ($apiDisplayAllRecords->isEmpty())
            {
                return response($this->handleResponse('not_found'), 404);
            }
            else
            {
                return response($this->handleResponse('success', $apiDisplayAllRecords), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Fetch all the records from the database.
     * @param  array  $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search)
    {
        $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchAllRecords($search),
            $this->modelName->getFields(),
            class_basename($this->modelName)
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Store a new record in the database.
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(UserRequest $request)
    {
        $apiInsertRecord = [
            'first_name'    => $request->get('first_name'),
            'last_name'     => $request->get('last_name'),
            'nickname'      => $request->get('nickname'),
            'email'         => $request->get('email'),
            'phone'         => $request->get('phone'),
            'password'      => $request->get('password'),
            'profile_image' => $request->get('profile_image'),
            'role_id'       => 1
        ];
        $apiInsertRecord['full_name'] = $request->get('first_name') . ' ' . $request->get('last_name');
        $saveRecord = $this->modelName->createRecord($apiInsertRecord);

        if ($saveRecord === true)
        {
            return response($this->handleResponse('success'), 201);
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Fetch a single record from the database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);

        if ($apiDisplaySingleRecord instanceof Collection)
        {
            if ($apiDisplaySingleRecord->isEmpty())
            {
                return response($this->handleResponse('not_found'), 404);
            }
            else
            {
                return response($this->handleResponse('success', $apiDisplaySingleRecord), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(UserRequest $request, $id)
    {
        $apiUpdateRecord = [
            'first_name'    => $request->get('first_name'),
            'last_name'     => $request->get('last_name'),
            'nickname'      => $request->get('nickname'),
            'email'         => $request->get('email'),
            'phone'         => $request->get('phone'),
            'password'      => $request->get('password'),
            'profile_image' => $request->get('profile_image'),
            'role_id'       => 1
        ];
        $apiUpdateRecord['full_name'] = $request->get('first_name') . ' ' . $request->get('last_name');
        $updateRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);

        if ($updateRecord === true)
        {
            return response($this->handleResponse('success'), 200);
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Delete a single record from the database
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);

        if ($apiDisplaySingleRecord instanceof Collection)
        {
            if ($apiDisplaySingleRecord->isEmpty())
            {
                return response($this->handleResponse('not_found'), 404);
            }
            else
            {
                $this->modelName->deleteRecord($id);
                return response($this->handleResponse('success'), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    public function statistics()
    {
        $reportableId = $this->modelName->getModelIdAndName()[0];
        $reportableType = $this->modelName->getModelIdAndName()[1];
        $records = $this->modelName->all()->toArray();
        $indicators = $this->modelName->getIndicators();

        $statisticalIndicators = [];
        $numberOfRecords = count($records);

        foreach ($indicators as $label)
        {
            $indicator = [];

            if ($label === 'users_by_role')
            {
                $roleIndicators = [];

                foreach ($this->modelNameRole->fetchUserRoles() as $role)
                {
                    $count = 0;
                    foreach ($records as $record)
                    {
                        if ($record['role_id'] === $role['id'])
                        {
                            $count++;
                        }
                    }

                    if ($count > 0) {
                        $roleIndicator = [
                            'reportable_id' => $reportableId,
                            'reportable_type' => $reportableType,
                            'label' => 'admin.reports.users.' . $label . '.' . $role['slug'],
                            'value' => $count,
                            'percentage' => ($count / $numberOfRecords) * 100,
                        ];

                        $roleIndicators[] = $roleIndicator;
                    }
                }

                if (!empty($roleIndicators)) {
                    $statisticalIndicators = array_merge($statisticalIndicators, $roleIndicators);
                }
            }
            else
            {
                $count = 0;
                if ($label === 'number_of_users')
                {
                    $count = $numberOfRecords;
                }
                elseif ($label === 'users_with_missing_phone')
                {
                    foreach ($records as $record)
                    {
                        if ($record['phone'] === null)
                        {
                            $count++;
                        }
                    }
                }
                elseif ($label === 'users_with_missing_profile_image')
                {
                    foreach ($records as $record)
                    {
                        if ($record['profile_image'] === null)
                        {
                            $count++;
                        }
                    }
                }
                elseif ($label === 'users_with_unverified_account')
                {
                    foreach ($records as $record)
                    {
                        if ($record['email_verified_at'] === null)
                        {
                            $count++;
                        }
                    }
                }
                elseif ($label === 'number_of_profile_modifications')
                {
                    foreach ($records as $record)
                    {
                        if ($record['created_at'] !== $record['updated_at'])
                        {
                            $count++;
                        }
                    }
                }

                $indicator = [
                    'reportable_id'   => $reportableId,
                    'reportable_type' => $reportableType,
                    'label'           => 'admin.reports.users.' . $label,
                    'value'           => $count,
                    'percentage'      => ($count / $numberOfRecords) * 100,
                ];

                $statisticalIndicators[] = $indicator;
            }
        }

        $newStatisticalIndicators = [];

        foreach ($statisticalIndicators as $item)
        {
            $fromDate = Carbon::now()->startOfWeek();
            $toDate = Carbon::now()->endOfWeek();

            $newItem = array_merge($item, [
                'from' => $fromDate->toDateTimeString(),
                'to' => $toDate->toDateTimeString(),
            ]);

            $newStatisticalIndicators[] = $newItem;
        }

        $statisticalIndicators = $newStatisticalIndicators;

        $this->modelName->select('id')->find($reportableId)->report()->insert($statisticalIndicators);
    }
}
