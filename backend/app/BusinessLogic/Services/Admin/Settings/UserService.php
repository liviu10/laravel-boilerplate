<?php

namespace App\BusinessLogic\Services\Admin\Settings;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\Settings\UserInterface;
use App\Http\Requests\Admin\Settings\UserRequest;
use App\Models\Admin\Settings\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * UserService is a service class the will implement all the methods from the UserInterface contract and will handle the business logic.
 */
class UserService implements UserInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new User();
    }

    /**
     * Fetch current authenticate user from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleFetchCurrentAuthUser()
    {
        $apiDisplayAllRecords = $this->modelName->fetchCurrentAuthUser();

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
     * @return \Illuminate\Http\Response
     */
    public function handleIndex()
    {
        $apiDisplayAllRecords = $this->modelName->fetchAllRecords();

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
     * Store a new record in the database.
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(UserRequest $request)
    {
        $apiInsertRecord = [
            'first_name'        => $request->get('first_name'),
            'last_name'         => $request->get('last_name'),
            'nickname'          => $request->get('nickname'),
            'email'             => $request->get('email'),
            'phone'             => $request->get('phone'),
            'password'          => $request->get('password'),
            'profile_image'     => $request->get('profile_image'),
            'user_role_type_id' => 1
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
            'first_name'        => $request->get('first_name'),
            'last_name'         => $request->get('last_name'),
            'nickname'          => $request->get('nickname'),
            'email'             => $request->get('email'),
            'phone'             => $request->get('phone'),
            'password'          => $request->get('password'),
            'profile_image'     => $request->get('profile_image'),
            'user_role_type_id' => 1
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
}
