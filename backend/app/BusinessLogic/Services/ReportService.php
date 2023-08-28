<?php

namespace App\BusinessLogic\Services;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\ReportInterface;
use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;

/**
 * ReportService is a service class the will implement all the methods from the ReportInterface contract and will handle the business logic.
 */
class ReportService implements ReportInterface
{
    use ApiResponseMessage;

    protected $modelName;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        $this->modelName = new Report();
    }

    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex()
    {
        $apiDisplayAllRecords = $this->modelName->fetchAllRecords();

        $modifiedRecords = [];

        foreach ($apiDisplayAllRecords as $item) {
            $modifiedRecords[] = [
                'value' => $item['reportable_id'],
                'label' => class_basename($item['reportable_type']),
            ];
        }

        if ($apiDisplayAllRecords instanceof \Illuminate\Support\Collection)
        {
            if ($apiDisplayAllRecords->isEmpty())
            {
                return response($this->handleResponse('not_found'), 200);
            }
            else
            {
                return response($this->handleResponse('success', $modifiedRecords), 200);
            }
        }
        else
        {
            return response($this->handleResponse('error_message'), 500);
        }
    }

    /**
     * Fetch a single record from the database.
     * @param  int $reportableId
     * @return \Illuminate\Http\Response
     */
    public function handleShow($reportableId)
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($reportableId);

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
}
