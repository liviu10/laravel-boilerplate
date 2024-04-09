<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Utilities\HandleApi;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    protected Comment $modelName;
    protected HandleApi $handleApi;

    public function __construct()
    {
        $this->modelName = new Comment();
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
     * @param CommentRequest $request
     * @return Response|ResponseFactory
     */
    public function store(CommentRequest $request): Response|ResponseFactory
    {
        $payload = $this->handleApi->handlePayload(
            CommentRequest::class,
            $this->modelName->getFillable()
        );

        $query = $this->modelName->createRecord($payload);

        return $this->handleApi->handleApiResponse(
            $query,
            Comment::class
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
     * @param CommentRequest $request
     * @param string $id
     * @return Response|ResponseFactory
     */
    public function update(CommentRequest $request, string $id): Response|ResponseFactory
    {
        $selectedRecord = $this->modelName->fetchSingleRecord($id);

        if ($selectedRecord instanceof Collection && $selectedRecord->isNotEmpty()) {
            $payload = $this->handleApi->handlePayload(
                CommentRequest::class,
                $this->modelName->getFillable(),
                $selectedRecord,
            );

            $query = $this->modelName->updateRecord($payload, $id);

            return $this->handleApi->handleApiResponse(
                $query,
                Comment::class
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
                Comment::class
            );
        } else {
            return $this->handleApi->handleApiResponse($selectedRecord);
        }
    }
}
