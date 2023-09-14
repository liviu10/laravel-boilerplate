<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\ResourceInterface;
use Illuminate\Support\Facades\Auth;
use App\Library\ApiResponse;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Collection;

/**
 * ResourceService is a service class the will implement all the methods from the ResourceInterface contract and will handle the business logic.
 */
class ResourceService implements ResourceInterface
{

    protected $modelName;
    protected $apiResponse;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Resource();
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
            'type'          => $request['type'],
            'path'          => $request['path'],
            'title'         => $request['title'] ?? null,
            'caption'       => $request['caption'] ?? null,
            'icon'          => $request['icon'] ?? null,
            'is_active'     => $request['is_active'] ?? false,
            'requires_auth' => $request['requires_auth'] ?? false,
            'user_id'       => Auth::user() ? Auth::user()->id : 1,
        ];
        $apiInsertRecord['layout'] = $this->handleLayoutPath($request['path']);
        $apiInsertRecord['name'] = $this->handleComponentName($request['path']);
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
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id)->toArray()[0];
        if ($apiDisplaySingleRecord && count($apiDisplaySingleRecord)) {
            $apiUpdateRecord = [
                'type'          => $request['type'] ?? $apiDisplaySingleRecord['type'],
                'path'          => $request['path'] ?? $apiDisplaySingleRecord['path'],
                'name'          => $request['name'] ?? $apiDisplaySingleRecord['name'],
                'title'         => $request['title'] ?? $apiDisplaySingleRecord['title'],
                'caption'       => $request['caption'] ?? $apiDisplaySingleRecord['caption'],
                'icon'          => $request['icon'] ?? $apiDisplaySingleRecord['icon'],
                'is_active'     => $request['is_active'] ?? $apiDisplaySingleRecord['is_active'],
                'requires_auth' => $request['requires_auth'] ?? $apiDisplaySingleRecord['requires_auth'],
                'user_id'       => Auth::user() ? Auth::user()->id : 1,
            ];
            $apiInsertRecord['layout'] = $this->handleLayoutPath($request['path']);
            $apiInsertRecord['component'] = $this->handleComponentPath($request['path']);
            $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
        }
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

        return 'src/layouts/' . $componentMainDirectory . 'Layout.vue';
    }

    public function handleComponentName(string $path): string
    {
        $item = array_filter(explode('/', $path), 'strlen');
        $componentName = '';

        if (substr(end($item), -1, 1) === 's') {
            $componentName = substr(end($item), 0, -1);
        }

        if (str_contains(end($item), '-')) {
            if (substr(end($item), -1, 1) === 's') {
                $componentName = substr(str_replace(' ', '', ucwords(str_replace('-', ' ', end($item)))), 0, -1);
            } else {
                $componentName = str_replace(' ', '', ucwords(str_replace('-', ' ', end($item))));
            }
        }

        return $componentName . 'Page';
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
        $urlParts = array_filter(explode('/', $path), 'strlen');
        $componentPath = 'pages/';
        foreach ($urlParts as $index => $item) {
            if ($index === count($urlParts)) {
                $componentName = ucfirst($item);
                if (substr($componentName, -1, 1) === 's') {
                    $componentName = substr($componentName, 0, -1);
                }

                if (str_contains($item, '-')) {
                    if (substr($componentName, -1, 1) === 's') {
                        $componentName = substr(str_replace(' ', '', ucwords(str_replace('-', ' ', $item))), 0, -1);
                    } else {
                        $componentName = str_replace(' ', '', ucwords(str_replace('-', ' ', $item)));
                    }
                }
                $componentPath .=  $componentName . 'Page.vue';
            } else {
                $componentPath .= $item . '/';
            }
        }
        $componentPath = rtrim($componentPath, '/');

        return $componentPath;
    }
}
