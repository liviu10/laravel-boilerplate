<?php

namespace App\BusinessLogic\Services;

use App\BusinessLogic\Interfaces\BaseInterface;
use App\BusinessLogic\Interfaces\NewsletterSubscriberInterface;
use App\Traits\ApiStatisticalIndicators;
use App\Models\NewsletterSubscriber;
use App\Library\ApiResponse;
use App\Library\Actions;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class NewsletterSubscriberService implements BaseInterface, NewsletterSubscriberInterface
{
    use ApiStatisticalIndicators;

    protected $modelName;
    protected $apiResponse;

    /**
     * Create a new instance of the NewsletterSubscriberService.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->modelName = new NewsletterSubscriber();
        $this->apiResponse = new ApiResponse();
    }

    /**
     * Handle the index action for displaying a list of records.
     * @param array $search An array of search parameters to filter records.
     * @return Response|ResponseFactory The response containing the list of records or a response factory.
     */
    public function handleIndex(array $search): Response|ResponseFactory
    {
        $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchAllRecords($search, 'paginate'),
            Actions::get,
            $this->modelName->getFields(),
            class_basename($this->modelName),
            null,
            $this->handleStatisticalIndicators()
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Handle the store action for creating a new record.
     * @param array $request The request data containing information for creating the record.
     * @return Response|ResponseFactory The response containing the created record or a response factory.
     */
    public function handleStore(array $request): Response|ResponseFactory
    {
        $apiInsertRecord = [
            'full_name' => $request['full_name'],
            'email' => $request['email'],
            'privacy_policy' => $request['privacy_policy'] !== null ? $request['privacy_policy'] : false,
        ];
        $createdRecord = $this->modelName->createRecord($apiInsertRecord);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse($createdRecord->toArray(), Actions::create);

        return $apiCreatedRecord;

        // $acceptedDomain = new AcceptedDomain();
        // $getEmailProvider = explode('.', substr(strstr($request->get('email'), '@'), 1));
        // $checkEmailProvider = $acceptedDomain->checkEmailProvider($getEmailProvider);

        // if (count($checkEmailProvider) === 2)
        // {
        //     $apiInsertRecord['valid_email'] = true;
        //     $apiInsertRecord['newsletter_campaign_id'] = 1;
        //     $saveRecord = $this->modelName->createRecord($apiInsertRecord);
        //     // TODO: create email WelcomeNewsletter
        //     if ($saveRecord === true)
        //     {
        //         return response($this->handleResponse('success'), 201);
        //     }
        //     else
        //     {
        //         return response($this->handleResponse('error_message'), 500);
        //     }
        // }
        // else
        // {
        //     return response($this->handleResponse('warning'), 422);
        // }
    }

    /**
     * Handle the show action for displaying a single record.
     * @param int $id The ID of the record to retrieve and display.
     * @return Response|ResponseFactory The response containing the single record or a response factory.
     */
    public function handleShow(int $id): Response|ResponseFactory
    {
        $apiDisplaySingleRecord = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchSingleRecord($id, 'relation'),
            Actions::get
        );

        return $apiDisplaySingleRecord;
    }

    /**
     * Handle the update action for modifying an existing record.
     * @param array $request The request data containing updated information for the record.
     * @param int $id The ID of the record to be updated.
     * @return Response|ResponseFactory The response containing the updated record or a response factory.
     */
    public function handleUpdate(array $request, int $id): Response|ResponseFactory
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
            $apiUpdateRecord = [
                'newsletter_campaign_id' => $request['newsletter_campaign_id'],
            ];
            $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse($updatedRecord->toArray(), Actions::update);
        } else {
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse(null, Actions::not_found_record);
        }

        return $apiUpdatedRecord;
    }

    /**
     * Handle the destroy action for deleting a record.
     * @param int $id The ID of the record to be deleted.
     * @return Response|ResponseFactory The response indicating the result of the deletion or a response factory.
     */
    public function handleDestroy(int $id): Response|ResponseFactory
    {
        if (Auth::user() && Auth::user()->role_id === 1) {
            $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
            if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
            }
            $apiDeleteRecord = $this->apiResponse->generateApiResponse($apiDisplaySingleRecord, Actions::delete);
            return $apiDeleteRecord;
        } else {
            return $this->apiResponse->generateApiResponse(null, Actions::not_allowed);
        }
    }

    public function handleStatisticalIndicators(): array
    {
        return [];
    }
}
