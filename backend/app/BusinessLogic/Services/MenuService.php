<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\MenuInterface;
use Illuminate\Support\Facades\Auth;
use App\Library\ApiResponse;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

/**
 * MenuService is a service class the will implement all the methods from the MenuInterface contract and will handle the business logic.
 */
class MenuService implements MenuInterface
{

    protected $modelName;
    protected $apiResponse;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Menu();
        $this->apiResponse = new ApiResponse();
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
            'get',
            $this->modelName->getFields(),
            class_basename($this->modelName),
            []
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
        $apiInsertRecord = [
            'path'          => $request['path'],
            'name'          => $request['name'],
            'title'         => $request['title'] ?? null,
            'caption'       => $request['caption'] ?? null,
            'icon'          => $request['icon'] ?? null,
            'is_active'     => $request['is_active'] ?? false,
            'requires_auth' => $request['requires_auth'] ?? false,
            'user_id'       => Auth::user() ? Auth::user()->id : 1,
        ];
        $apiInsertRecord['layout'] = $this->handleLayoutPath($request['path']);
        $apiInsertRecord['component'] = $this->handleComponentPath($request['path']);
        $createdRecord = $this->modelName->createRecord($apiInsertRecord);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), 'create');

        return $apiCreatedRecord;
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
            'path'          => $request['path'],
            'name'          => $request['name'],
            'title'         => $request['title'] ?? null,
            'caption'       => $request['caption'] ?? null,
            'icon'          => $request['icon'] ?? null,
            'is_active'     => $request['is_active'] ?? false,
            'requires_auth' => $request['requires_auth'] ?? false,
            'user_id'       => Auth::user() ? Auth::user()->id : 1,
        ];
        $apiInsertRecord['layout'] = $this->handleLayoutPath($request['path']);
        $apiInsertRecord['component'] = $this->handleComponentPath($request['path']);
        $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
        $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), 'update');

        return $apiUpdatedRecord;
    }

    /**
     * Determine the layout path based on the component's main directory.
     * This method takes a component path and examines its main directory to determine
     * the appropriate layout path. Depending on the main directory, it returns the
     * corresponding layout path for either the "admin" or "client" context.
     * @param string $path The component path used to determine the layout.
     * @return string The layout path based on the component's main directory.
     */
    public function handleLayoutPath(string $path): string
    {
        $componentMainDirectory = ucfirst(explode('/', $path)[1]);

        if ($componentMainDirectory === 'admin') {
            return 'src/layouts/' . $componentMainDirectory . 'Layout.vue';
        }

        if ($componentMainDirectory === 'client') {
            return 'src/layouts/' . $componentMainDirectory . 'Layout.vue';
        }
    }

    /**
     * Transforms a component path into a page path.
     * This method takes a component path, which typically represents a Vue.js
     * component location, and converts it into a page path format. It extracts
     * the main directory, subdirectory, and component name from the input path
     * and constructs a page path using them.
     * @param string $path The component path to be transformed.
     * @return string The page path generated from the component path.
     */
    public function handleComponentPath(string $path): string
    {
        $componentMainDirectory = explode('/', $path)[1];
        $componentSubdirectory = ucwords(str_replace('-', '', explode('/', $path)[2]));
        $componentName = explode('/', $path)[1] . '.vue';

        return 'pages/' . $componentMainDirectory . '/' . $componentSubdirectory . '/' . $componentName;
    }
}
