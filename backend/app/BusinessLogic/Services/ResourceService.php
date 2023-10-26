<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\ResourceInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\Resource;
use App\Utilities\ApiResponse;
use App\Utilities\ApiCheckPermission;
use App\Utilities\ApiResourcePermission;
use App\Utilities\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResourceService implements BaseInterface, ResourceInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;
    protected $checkPermission;
    protected $resourcePermissions;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new Resource();
        $this->apiResponse = new ApiResponse();
        $this->checkPermission = new ApiCheckPermission();
        $this->resourcePermissions = new ApiResourcePermission();
        $this->handleResourcePermissions();
    }

    /**
     * Handle the index action for displaying a list of records.
     * @param array $search An array of search parameters to filter records.
     * @return Response|ResponseFactory|View The response containing the list of records,
     * a response factory or a view template.
     */
    public function handleIndex(array $search): Response|ResponseFactory|View
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
        $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchAllRecords($search),
            Actions::get
        );

        if (Request::capture()->expectsJson()) {
            return $apiDisplayAllRecords;
        } else {
            $displayAllRecords = collect($apiDisplayAllRecords->original);
            return view('pages.admin.settings.resources.index', compact('displayAllRecords'));
        }
    } else {
        return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
    }
    }

    /**
     * Handle the store action for creating a new record.
     * @param array $request The request data containing information for creating the record.
     * @return Response|ResponseFactory The response containing the created record or a response factory.
     */
    public function handleStore(array $request): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
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
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), Actions::create);

        return $apiCreatedRecord;
    } else {
        return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
    }
    }

    /**
     * Handle the show action for displaying a single record.
     * @param int $id The ID of the record to retrieve and display.
     * @return Response|ResponseFactory The response containing the single record or a response factory.
     */
    public function handleShow(int $id): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
        $apiDisplaySingleRecord = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchSingleRecord($id, 'relation'),
            Actions::get
        );

        return $apiDisplaySingleRecord;
    } else {
        return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
    }
    }

    /**
     * Handle the update action for modifying an existing record.
     * @param array $request The request data containing updated information for the record.
     * @param int $id The ID of the record to be updated.
     * @return Response|ResponseFactory The response containing the updated record or a response factory.
     */
    public function handleUpdate(array $request, int $id): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && count($apiDisplaySingleRecord)) {
            $apiUpdateRecord = [
                'type'          => array_key_exists('type', $request)
                    ? $request['type']
                    : $apiDisplaySingleRecord->toArray()[0]['type'],
                'path'          => array_key_exists('path', $request)
                    ? $request['path']
                    : $apiDisplaySingleRecord->toArray()[0]['path'],
                'title'         => array_key_exists('title', $request)
                    ? $request['title']
                    : $apiDisplaySingleRecord->toArray()[0]['title'],
                'caption'       => array_key_exists('caption', $request)
                    ? $request['caption']
                    : $apiDisplaySingleRecord->toArray()[0]['caption'],
                'icon'          => array_key_exists('icon', $request)
                    ? $request['icon']
                    : $apiDisplaySingleRecord->toArray()[0]['icon'],
                'is_active'     => array_key_exists('is_active', $request)
                    ? $request['is_active']
                    : $apiDisplaySingleRecord->toArray()[0]['is_active'],
                'requires_auth' => array_key_exists('requires_auth', $request)
                    ? $request['requires_auth']
                    : $apiDisplaySingleRecord->toArray()[0]['requires_auth'],
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
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), Actions::update);
        } else {
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse(null, Actions::not_found_record);
        }

        return $apiUpdatedRecord;
    } else {
        return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
    }
    }

    /**
     * Handle the destroy action for deleting a record.
     * @param int $id The ID of the record to be deleted.
     * @return Response|ResponseFactory The response indicating the result of the deletion or a response factory.
     */
    public function handleDestroy(int $id): Response|ResponseFactory
    {
        if ($this->checkPermission->handleApiCheckPermission()) {
            $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
            if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
            }
            $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, Actions::delete);

            return $apiDeleteRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::forbidden);
        }
    }

    /**
     * Parses a given path and extracts information to configure a component.
     * @param string $path The path to be processed.
     * @return array An associative array containing the following keys:
     * layout_path, component_name, component_path, title_translation and caption_translation
     */
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

    public function handleStatisticalIndicators(): array
    {
        return [];
    }

    public function handleResourcePermissions(): void
    {
        $resources = $this->modelName->getResources();
        $this->resourcePermissions->handleApiCreateResourcePermission($resources);
    }
}
