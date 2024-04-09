<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use App\Utilities\HandleApi;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class ContactMessageController extends Controller
{
    protected ContactMessage $modelName;
    protected HandleApi $handleApi;

    public function __construct()
    {
        $this->modelName = new ContactMessage();
        $this->handleApi = new HandleApi();
    }

    /**
     * Display a listing of the resource.
     * @param array $search
     * @return Response|ResponseFactory
     */
    public function index(array $search = []): Response|ResponseFactory
    {
        $query = $this->modelName->fetchAllRecords($search);

        return $this->handleApi->handleApiResponse($query);
    }

    /**
     * Store a newly created resource in storage.
     * @param ContactMessageRequest $request
     * @return Response|ResponseFactory
     */
    public function store(ContactMessageRequest $request): Response|ResponseFactory
    {
        $payload = $this->handleApi->handlePayload(
            ContactMessageRequest::class,
            $this->modelName->getFillable()
        );

        $query = $this->modelName->createRecord($payload);

        return $this->handleApi->handleApiResponse(
            $query,
            ContactMessage::class
        );
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return Response|ResponseFactory
     */
    public function show(string $id): Response|ResponseFactory
    {
        $query = $this->modelName->fetchSingleRecord($id);

        return $this->handleApi->handleApiResponse($query);
    }

    /**
     * Update the specified resource in storage.
     * @param ContactMessageRequest $request
     * @param string $id
     * @return Response|ResponseFactory
     */
    public function update(ContactMessageRequest $request, string $id): Response|ResponseFactory
    {
        $selectedRecord = $this->modelName->fetchSingleRecord($id);

        if ($selectedRecord instanceof Collection && $selectedRecord->isNotEmpty()) {
            $payload = $this->handleApi->handlePayload(
                ContactMessageRequest::class,
                $this->modelName->getFillable(),
                $selectedRecord,
            );

            $query = $this->modelName->updateRecord($payload, $id);

            return $this->handleApi->handleApiResponse(
                $query,
                ContactMessage::class
            );
        } else {
            return $this->handleApi->handleApiResponse($selectedRecord);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Response|ResponseFactory
     */
    public function destroy(string $id): Response|ResponseFactory
    {
        $selectedRecord = $this->modelName->fetchSingleRecord($id);

        if ($selectedRecord instanceof Collection && $selectedRecord->isNotEmpty()) {
            $query = $this->modelName->deleteRecord($id);

            return $this->handleApi->handleApiResponse(
                $query,
                ContactMessage::class
            );
        } else {
            return $this->handleApi->handleApiResponse($selectedRecord);
        }
    }
}
