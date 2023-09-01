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
            class_basename($this->modelName),
            [],
            $this->getStatisticalIndicators()
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

    public function getStatisticalIndicators()
    {
        $apiAllRecordDetails = $this->modelName->fetchAllRecordDetails();
        $statisticalIndicators = $this->modelName->getStatisticalIndicators();
        $indicators = [];
        // $count = 0;

        foreach ($apiAllRecordDetails as $record)
        {
            $indicators += [];
            foreach ($statisticalIndicators as $key => $options)
            {
                $indicators += [
                    (string)$key => []
                ];
                if ($options['type'] === 'count')
                {
                    if (!array_key_exists('condition', $options))
                    {
                        $indicators[(string)$key]['number'] = count($apiAllRecordDetails);
                        $indicators[(string)$key]['percentage'] = null;
                    }
                    else
                    {
                        if (array_key_exists($options['field'], $record))
                        {
                            $indicators[(string)$key]['number'] = null;
                            $indicators[(string)$key]['percentage'] = null;
                        }
                    }
                }
                elseif ($options['type'] === 'custom')
                {
                    if ($options['condition'] === 'foreign_key')
                    {
                        $indicators[(string)$key]['number'] = null;
                        $indicators[(string)$key]['percentage'] = null;
                    }
                }
                // if ($option === 'total')
                // {
                //     $indicators += [
                //         (string)$indicator => [
                //             'number' => count($apiAllRecordDetails),
                //             'percentage' => null
                //         ]
                //     ];
                // }
            }
            
            // foreach ($record as $key => $value)
            // {
            //     if ($value === null)
            //     {
            //         $count++;
            //     }
            // }

            // foreach ($statisticalIndicators as $indicator)
            // {
            //     $indicators += [
            //         (string)$indicator => [
                        // 'number' => null,
                        // 'percentage' => null
            //         ]
            //     ];

            //     if ($indicator === 'number_of_records')
            //     {
            //         $indicators[(string)$indicator]['number'] = count($apiAllRecordDetails);
            //         $indicators[(string)$indicator]['percentage'] = 0;
            //     }
            //     else
            //     {
            //         $indicators[(string)$indicator]['number'] = $count;
            //         $indicators[(string)$indicator]['percentage'] = 0;
            //     }
            // }
        }

        dd($indicators);

        
        // $usersWithMissingPhone = 0;
        // $usersWithMissingProfileImage = 0;
        // $usersWithUnverifiedAccount = 0;
        // $usersByRoleIdWebmaster = 0;
        // $usersByRoleIdAdministrator = 0;
        // $usersByRoleIdAccountant = 0;
        // $usersByRoleIdSales = 0;
        // $usersByRoleIdClient = 0;
        // $numberOfProfileModifications = 0;

        // foreach ($apiAllRecordDetails as $item) {
        //     $item['phone'] || $usersWithMissingPhone++;

        //     $item['profile_image'] || $usersWithMissingProfileImage++;

        //     $item['email_verified_at'] || $usersWithUnverifiedAccount++;

        //     $item['role_id'] === 1 ? $usersByRoleIdWebmaster++ : null;

        //     $item['role_id'] === 2 ? $usersByRoleIdAdministrator++ : null;

        //     $item['role_id'] === 3 ? $usersByRoleIdAccountant++ : null;

        //     $item['role_id'] === 4 ? $usersByRoleIdSales++ : null;

        //     $item['role_id'] === 5 ? $usersByRoleIdClient++ : null;

        //     $item['created_at'] !== $item['updated_at'] ? $numberOfProfileModifications++ : null;
        // }

        // $indicators = [
        //     'number_of_users' => [
        //         'number'     => $numberOfRecords,
        //         'percentage' => null,
        //     ],
        //     'users_with_missing_phone' => [
        //         'number'     => $usersWithMissingPhone,
        //         'percentage' => ($usersWithMissingPhone / $numberOfRecords) * 100,
        //     ],
        //     'users_with_missing_profile_image' => [
        //         'number'     => $usersWithMissingProfileImage,
        //         'percentage' => ($usersWithMissingProfileImage / $numberOfRecords) * 100,
        //     ],
        //     'users_with_unverified_account' => [
        //         'number'     => $usersWithUnverifiedAccount,
        //         'percentage' => ($usersWithUnverifiedAccount / $numberOfRecords) * 100,
        //     ],
        //     'users_by_role' => [
        //         'webmaster' => [
        //             'number'     => $usersByRoleIdWebmaster,
        //             'percentage' => ($usersByRoleIdWebmaster / $numberOfRecords) * 100,
        //         ],
        //         'administrator' => [
        //             'number'     => $usersByRoleIdAdministrator,
        //             'percentage' => ($usersByRoleIdAdministrator / $numberOfRecords) * 100,
        //         ],
        //         'accountant' => [
        //             'number'     => $usersByRoleIdAccountant,
        //             'percentage' => ($usersByRoleIdAccountant / $numberOfRecords) * 100,
        //         ],
        //         'sales' => [
        //             'number'     => $usersByRoleIdSales,
        //             'percentage' => ($usersByRoleIdSales / $numberOfRecords) * 100,
        //         ],
        //         'client' => [
        //             'number'     => $usersByRoleIdClient,
        //             'percentage' => ($usersByRoleIdClient / $numberOfRecords) * 100,
        //         ],
        //     ],
        //     'number_of_profile_modifications' => [
        //         'number'     => $numberOfProfileModifications,
        //         'percentage' => ($numberOfProfileModifications / $numberOfRecords) * 100,
        //     ],
        // ];

        // return $indicators;
    }
}
