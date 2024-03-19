<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ApiInterface;
use App\Models\NotificationTemplate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationTemplateRequest;
use Illuminate\Support\Facades\Auth;
use Exception;

class NotificationTemplateController extends Controller implements ApiInterface
{
    protected NotificationTemplate $modelName;

    public function __construct()
    {
        $this->modelName = new NotificationTemplate();
    }

    /**
     * Handle the index operation.
     *
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $allRecords = $this->modelName->fetchAllRecords($request->all());
        $data = [];

        if ($allRecords instanceof Collection) {
            $data['title'] = $allRecords->isNotEmpty()
                ? __('translations.success_title')
                : __('translations.not_found_title');
            $data['description'] = $allRecords->isNotEmpty()
                ? __('translations.success_message')
                : __('translations.not_found_message');
            $data['records'] = $allRecords;
            $statusCode = 200;
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the store operation.
     *
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function store(Request $request): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(NotificationTemplateRequest::rules());

        $insertRecord = [
            'notification_type_id' => $validatedRequest['notification_type_id'],
            'notification_condition_id' => $validatedRequest['notification_condition_id'],
            'title' => $validatedRequest['title'],
            'content' => $validatedRequest['content'],
            'user_id' => Auth::user() ? Auth::user()->id : 1,
        ];

        $createdRecord = $this->modelName->createRecord($insertRecord);
        $data = [];

        if ($createdRecord instanceof NotificationTemplate) {
            $data['title'] = __('translations.success_title');
            $data['description'] = __('translations.success_message');
            $data['results'] = $createdRecord;
            $statusCode = 201;
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the show operation.
     *
     * @param string $id
     * @param string|null $type
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function show(string $id, string|null $type = null): Response|ResponseFactory
    {
        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            $data['title'] = $showRecord->isNotEmpty()
                ? __('translations.success_title')
                : __('translations.not_found_title');
            $data['description'] = $showRecord->isNotEmpty()
                ? __('translations.success_message')
                : __('translations.not_found_message');
            $data['records'] = $showRecord;
            $statusCode = 200;
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the update operation.
     *
     * @param Request $request
     * @param string $id
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function update(Request $request, string $id): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(NotificationTemplateRequest::rules());

        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            if ($showRecord->isNotEmpty()) {
                $updateRecord = [
                    'notification_type_id' => array_key_exists('notification_type_id', $request->all())
                        ? $validatedRequest['notification_type_id']
                        : $showRecord->toArray()[0]['notification_type_id'],
                    'notification_condition_id' => array_key_exists('notification_condition_id', $request->all())
                        ? $validatedRequest['notification_condition_id']
                        : $showRecord->toArray()[0]['notification_condition_id'],
                    'title' => array_key_exists('title', $request->all())
                        ? $validatedRequest['title']
                        : $showRecord->toArray()[0]['title'],
                    'content' => array_key_exists('content', $request->all())
                        ? $validatedRequest['content']
                        : $showRecord->toArray()[0]['content'],
                    'user_id' => Auth::user() ? Auth::user()->id : 1,
                ];

                $editedRecord = $this->modelName->updateRecord($updateRecord, $id);

                $data['title'] = __('translations.success_title');
                $data['description'] = __('translations.success_message');
                $data['results'] = $editedRecord;
                $statusCode = 200;
            } else {
                $data['title'] = __('translations.not_found_title');
                $data['description'] = __('translations.not_found_message');
                $data['results'] = [];
                $statusCode = 422;
            }
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the destroy operation.
     *
     * @param string $id
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function destroy(string $id): Response|ResponseFactory
    {
        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            if ($showRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
                $data['title'] = __('translations.success_title');
                $data['description'] = __('translations.success_message');
                $data['results'] = $showRecord;
                $statusCode = 200;
            } else {
                $data['title'] = __('translations.not_found_title');
                $data['description'] = __('translations.not_found_message');
                $data['results'] = [];
                $statusCode = 422;
            }
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }
}
