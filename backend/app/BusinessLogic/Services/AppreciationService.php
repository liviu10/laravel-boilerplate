<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\AppreciationInterface;
use App\Library\ApiResponse;
use App\Http\Requests\AppreciationRequest;
use App\Models\Appreciation;
use Illuminate\Database\Eloquent\Collection;

/**
 * AppreciationService is a service class the will implement all the methods from the AppreciationInterface contract and will handle the business logic.
 */
class AppreciationService implements AppreciationInterface
{
    use ApiResponseMessage;

    protected $modelName;
    protected $apiResponse;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Appreciation();
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
            $this->modelName->getFields(),
            class_basename($this->modelName),
            [],
            $this->getStatisticalIndicators()
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Store a new record in the database.
     * @param  AppreciationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore(AppreciationRequest $request)
    {
        $apiInsertRecord = [
            'likes'      => $request->get('likes') ? $request->get('likes') : null,
            'dislikes'   => $request->get('dislikes') ? $request->get('dislikes') : null,
            'rating'     => $request->get('rating') ? $request->get('rating') : null,
            'content_id' => 1,
            'user_id'    => 1,
        ];
        $saveRecord = $this->modelName->createRecord($apiInsertRecord);

        if ($saveRecord === true)
        {
            return response($this->handleResponse('success'), 201);
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Fetch a single record from the database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);

        if ($apiDisplaySingleRecord instanceof Collection)
        {
            if ($apiDisplaySingleRecord->isEmpty())
            {
                return response($this->handleResponse('not_found'), 404);
            }
            else
            {
                return response($this->handleResponse('success', $apiDisplaySingleRecord), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  AppreciationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate(AppreciationRequest $request, $id)
    {
        $apiUpdateRecord = [
            'likes'      => $request->get('likes') ? $request->get('likes') : null,
            'dislikes'   => $request->get('dislikes') ? $request->get('dislikes') : null,
            'rating'     => $request->get('rating') ? $request->get('rating') : null,
            'content_id' => 1,
            'user_id'    => 1,
        ];
        $updateRecord = $this->modelName->createRecord($apiUpdateRecord, $id);

        if ($updateRecord === true)
        {
            return response($this->handleResponse('success'), 201);
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Delete a single record from the database
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);

        if ($apiDisplaySingleRecord instanceof Collection)
        {
            if ($apiDisplaySingleRecord->isEmpty())
            {
                return response($this->handleResponse('not_found'), 404);
            }
            else
            {
                $this->modelName->deleteRecord($id);
                return response($this->handleResponse('success'), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    public function getStatisticalIndicators()
    {
        $apiAllRecordDetails = $this->modelName->fetchAllRecordDetails();

        $numberOfAppreciations = count($apiAllRecordDetails);
        $numberOfLikes = 0;
        $numberOfDislikes = 0;
        $numberOfRatingVeryBad = 0;
        $totalRatingVeryBad = 0;
        $numberOfRatingBad = 0;
        $numberOfRatingNeutral = 0;
        $numberOfRatingGood = 0;
        $numberOfRatingVeryGood = 0;
        $numberOfRatingExcellent = 0;

        foreach ($apiAllRecordDetails as $item) {
            $item['likes'] !== 0 ? $numberOfLikes++ : null;

            $item['dislikes'] !== 0 ? $numberOfDislikes++ : null;

            $item['rating'] >= 0 && $item['rating'] < 1 ? $numberOfRatingVeryBad++ : null;

            $item['rating'] >= 1 && $item['rating'] < 2 ? $numberOfRatingBad++ : null;

            $item['rating'] >= 2 && $item['rating'] < 3 ? $numberOfRatingNeutral++ : null;

            $item['rating'] >= 3 && $item['rating'] < 4 ? $numberOfRatingGood++ : null;

            $item['rating'] >= 4 && $item['rating'] < 5 ? $numberOfRatingVeryGood++ : null;

            $item['rating'] === 5 ? $numberOfRatingExcellent++ : null;
        }

        $indicators = [
            'number_of_appreciations' => [
                'number'     => $numberOfAppreciations,
                'percentage' => null,
            ],
            'number_of_likes' => [
                'number'     => $numberOfLikes,
                'percentage' => ($numberOfLikes / $numberOfAppreciations) * 100,
            ],
            'number_of_dislikes' => [
                'number'     => $numberOfDislikes,
                'percentage' => ($numberOfDislikes / $numberOfAppreciations) * 100,
            ],
            'number_of_ratings' => [
                'very_bad' => [
                    'number'     => $numberOfRatingVeryBad,
                    'average'    => 1,
                    'percentage' => ($numberOfRatingVeryBad / $numberOfAppreciations) * 100,
                ],
                'bad' => [
                    'number'     => $numberOfRatingBad,
                    'average'    => 1,
                    'percentage' => ($numberOfRatingBad / $numberOfAppreciations) * 100,
                ],
                'neutral' => [
                    'number'     => $numberOfRatingNeutral,
                    'average'    => 1,
                    'percentage' => ($numberOfRatingNeutral / $numberOfAppreciations) * 100,
                ],
                'good' => [
                    'number'     => $numberOfRatingGood,
                    'average'    => 1,
                    'percentage' => ($numberOfRatingGood / $numberOfAppreciations) * 100,
                ],
                'very_good' => [
                    'number'     => $numberOfRatingVeryGood,
                    'average'    => 1,
                    'percentage' => ($numberOfRatingVeryGood / $numberOfAppreciations) * 100,
                ],
                'excellent' => [
                    'number'     => $numberOfRatingExcellent,
                    'average'    => 1,
                    'percentage' => ($numberOfRatingExcellent / $numberOfAppreciations) * 100,
                ],
            ],
        ];

        return $indicators;
    }
}
