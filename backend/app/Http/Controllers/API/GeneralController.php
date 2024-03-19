<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ApiInterface;
use App\Interfaces\GeneralInterface;
use App\Models\General;
use App\Http\Requests\GeneralRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Exception;

class GeneralController extends Controller implements ApiInterface, GeneralInterface
{
    protected General $modelName;

    public function __construct()
    {
        $this->modelName = new General();
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
        $validatedRequest = $request->validate(GeneralRequest::rules());

        $insertRecord = [
            'generalable_id' => $validatedRequest['generalable_id'],
            'generalable_type' => $validatedRequest['generalable_type'],
            'value' => $validatedRequest['value'],
            'label' => $validatedRequest['label'],
            'key' => str_replace(' ', '_', strtolower($validatedRequest['label'])),
            'user_id' => Auth::user() ? Auth::user()->id : 1,
        ];

        $createdRecord = $this->modelName->createRecord($insertRecord);
        $data = [];

        if ($createdRecord instanceof General) {
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
        $validatedRequest = $request->validate(GeneralRequest::rules());

        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            if ($showRecord->isNotEmpty()) {
                $updateRecord = [
                    'generalable_id' => array_key_exists('generalable_id', $request->all())
                        ? $validatedRequest['generalable_id']
                        : $showRecord->toArray()[0]['generalable_id'],
                    'generalable_type' => array_key_exists('generalable_type', $request->all())
                        ? $validatedRequest['generalable_type']
                        : $showRecord->toArray()[0]['generalable_type'],
                    'value' => array_key_exists('value', $request->all())
                        ? $validatedRequest['value']
                        : $showRecord->toArray()[0]['value'],
                    'label' => array_key_exists('label', $request->all())
                        ? $validatedRequest['label']
                        : $showRecord->toArray()[0]['label'],
                ];

                $updateRecord['key'] = str_replace(' ', '_', strtolower($validatedRequest['label']));

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
        abort(405);
    }

    /**
     * Handle fetch model names operation.
     *
     * @return Response|ResponseFactory
     */
    public function fetchModelNames(): Response|ResponseFactory
    {
        $allRecords = $this->modelName->fetchModelNames();
        $data = [
            'title' => __('translations.success_title'),
            'description' => __('translations.success_message'),
            'records' => $allRecords,
        ];

        return response($data, 200);
    }

    /**
     * Handle apply migrations operation.
     *
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function applyMigrations(): Response|ResponseFactory
    {
        Artisan::call('migrate:fresh');

        $data = [
            'title' => __('translations.success_title'),
            'description' => __('translations.success_message'),
        ];

        return response($data, 200);
    }

    /**
     * Handle apply seeders operation.
     *
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function applySeeders(): Response|ResponseFactory
    {
        Artisan::call('db:seed');

        $data = [
            'title' => __('translations.success_title'),
            'description' => __('translations.success_message'),
        ];

        return response($data, 200);
    }

    /**
     * Handle optimize application operation.
     *
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function optimizeApplication(): Response|ResponseFactory
    {
        Artisan::call('optimize:clear');

        $data = [
            'title' => __('translations.success_title'),
            'description' => __('translations.success_message'),
        ];

        return response($data, 200);
    }
}
