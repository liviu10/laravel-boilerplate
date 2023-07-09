<?php

namespace App\BusinessLogic\Services\Admin\Settings;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\Settings\FrontMenuInterface;
use App\Http\Requests\Admin\Settings\FrontMenuRequest;
use App\Models\Admin\Settings\FrontMenu;
use Illuminate\Database\Eloquent\Collection;

/**
 * FrontMenuService is a service class the will implement all the methods from the FrontMenuInterface contract and will handle the business logic.
 */
class FrontMenuService implements FrontMenuInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new FrontMenu();
    }

    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex()
    {
        $apiDisplayAllRecords = $this->modelName->fetchAllRecords();

        if ($apiDisplayAllRecords instanceof \Illuminate\Database\Eloquent\Collection)
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
     * @param  FrontMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(FrontMenuRequest $request)
    {
        $apiInsertRecord = [
            'path'      => $request->get('path'),
            'name'      => $request->get('name'),
            'title'     => $request->get('title'),
            'caption'   => $request->get('caption'),
            'icon'      => $request->get('icon'),
            'is_active' => $request->get('is_active'),
        ];
        $apiInsertRecord['component'] = 'pages/' . $request->get('name') . 'Page.vue';
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
     * @param  FrontMenuRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(FrontMenuRequest $request, $id)
    {
        $apiUpdateRecord = [
            'path'      => $request->get('path'),
            'name'      => $request->get('name'),
            'title'     => $request->get('title'),
            'caption'   => $request->get('caption'),
            'icon'      => $request->get('icon'),
            'is_active' => $request->get('is_active'),
        ];
        $apiUpdateRecord['component'] = 'pages/' . $request->get('name') . 'Page.vue';
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
}
