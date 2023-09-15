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
            'icon'          => $request['icon'] ?? null,
            'is_active'     => $request['is_active'] ?? false,
            'requires_auth' => $request['requires_auth'] ?? false,
            'user_id'       => Auth::user() ? Auth::user()->id : 1,
        ];

        if ($request['type'] === 'Menu') {
            $componentDetails = $this->handleComponentDetails($request['path']);
            $apiInsertRecord['name'] = $componentDetails['component_name'];
            $apiInsertRecord['component'] = $componentDetails['component_path'];
            $apiInsertRecord['layout'] = $componentDetails['layout_path'];
            $apiInsertRecord['title'] = $componentDetails['title_translation'];
            $apiInsertRecord['caption'] = $componentDetails['caption_translation'];
        }

        if ($request['type'] === 'API') {
            $apiInsertRecord['name'] = null;
            $apiInsertRecord['component'] = null;
            $apiInsertRecord['layout'] = null;
            $apiInsertRecord['title'] = null;
            $apiInsertRecord['caption'] = null;
        }

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
                'title'         => $request['title'] ?? $apiDisplaySingleRecord['title'],
                'caption'       => $request['caption'] ?? $apiDisplaySingleRecord['caption'],
                'icon'          => $request['icon'] ?? $apiDisplaySingleRecord['icon'],
                'is_active'     => $request['is_active'] ?? $apiDisplaySingleRecord['is_active'],
                'requires_auth' => $request['requires_auth'] ?? $apiDisplaySingleRecord['requires_auth'],
                'user_id'       => Auth::user() ? Auth::user()->id : 1,
            ];

            if ($request['type'] === 'Menu') {
                if ($request['path'] && $request['path'] !== null) {
                    $componentDetails = $this->handleComponentDetails($request['path']);
                    $apiUpdateRecord['name'] = $componentDetails['component_name'];
                    $apiUpdateRecord['component'] = $componentDetails['component_path'];
                    $apiUpdateRecord['layout'] = $componentDetails['layout_path'];
                    $apiUpdateRecord['title'] = $componentDetails['title_translation'];
                    $apiUpdateRecord['caption'] = $componentDetails['caption_translation'];
                } else {
                    $apiUpdateRecord['name'] = $apiDisplaySingleRecord['name'];
                    $apiUpdateRecord['component'] = $apiDisplaySingleRecord['component'];
                    $apiUpdateRecord['layout'] = $apiDisplaySingleRecord['layout'];
                    $apiUpdateRecord['title'] = $apiDisplaySingleRecord['title'];
                    $apiUpdateRecord['caption'] = $apiDisplaySingleRecord['caption'];
                }
            }

            if ($request['type'] === 'API') {
                $apiUpdateRecord['name'] = null;
                $apiUpdateRecord['component'] = null;
                $apiUpdateRecord['layout'] = null;
                $apiUpdateRecord['title'] = null;
                $apiUpdateRecord['caption'] = null;
            }

            $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), 'update');

            return $apiUpdatedRecord;
        }
    }

    public function handleComponentDetails(string $path): array
    {
        $item = array_filter(explode('/', $path), 'strlen');

        $layoutPath = 'src/layouts/' . ucfirst($item[1]) . 'Layout.vue';
        $componentName = '';
        $componentPath = 'pages';
        $titleTranslation = '';
        $captionTranslation = '';

        if (substr(end($item), -1, 1) === 's') {
            $componentName = ucfirst(substr(end($item), 0, -1));
        } else {
            $componentName = ucfirst(end($item));
        }
        if (str_contains(end($item), '-')) {
            if (substr(end($item), -1, 1) === 's') {
                $componentName = substr(str_replace(' ', '', ucwords(str_replace('-', ' ', end($item)))), 0, -1);
            } else {
                $componentName = str_replace(' ', '', ucwords(str_replace('-', ' ', end($item))));
            }
        }

        foreach ($item as $key => $value) {
            if ($key === count($item)) {
                $componentPath .= '/' . $componentName . 'Page.vue';
            } else {
                $componentPath .= '/' . $value;
            }
        }
        $componentPath = ltrim($componentPath, '/');

        foreach ($item as $key => $value) {
            if (str_contains($value, '-')) {
                $titleTranslation .= '.' . str_replace('-', '_', $value);
                $captionTranslation .= '.' . str_replace('-', '_', $value);
            } else {
                $titleTranslation .= '.' . $value;
                $captionTranslation .= '.' . $value;
            }
        }
        $titleTranslation = ltrim($titleTranslation, '.');
        $captionTranslation = ltrim($captionTranslation, '.');

        $componentInformation = [
            'layout_path' => $layoutPath,
            'component_name' => $componentName . 'Page',
            'component_path' => $componentPath,
            'title_translation' => $titleTranslation . '.title',
            'caption_translation' => $captionTranslation . '.description',
        ];

        return $componentInformation;
    }
}
