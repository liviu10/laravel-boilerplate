<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterCampaignRequest;
use App\Models\NewsletterCampaign;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Utilities\HandleApi;
use Illuminate\Database\Eloquent\Collection;

class NewsletterCampaignController extends Controller
{
    protected NewsletterCampaign $modelName;
    protected HandleApi $handleApi;

    public function __construct()
    {
        $this->modelName = new NewsletterCampaign();
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
     * @param NewsletterCampaignRequest $request
     * @return Response|ResponseFactory
     */
    public function store(NewsletterCampaignRequest $request): Response|ResponseFactory
    {
        $payload = $this->handleApi->handlePayload(
            NewsletterCampaignRequest::class,
            $this->modelName->getFillable()
        );

        $query = $this->modelName->createRecord($payload);

        return $this->handleApi->handleApiResponse(
            $query,
            NewsletterCampaign::class
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
     * @param NewsletterCampaignRequest $request
     * @param string $id
     * @return Response|ResponseFactory
     */
    public function update(NewsletterCampaignRequest $request, string $id): Response|ResponseFactory
    {
        $selectedRecord = $this->modelName->fetchSingleRecord($id);

        if ($selectedRecord instanceof Collection && $selectedRecord->isNotEmpty()) {
            $payload = $this->handleApi->handlePayload(
                NewsletterCampaignRequest::class,
                $this->modelName->getFillable(),
                $selectedRecord,
            );

            $query = $this->modelName->updateRecord($payload, $id);

            return $this->handleApi->handleApiResponse(
                $query,
                NewsletterCampaign::class
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
                NewsletterCampaign::class
            );
        } else {
            return $this->handleApi->handleApiResponse($selectedRecord);
        }
    }
}
