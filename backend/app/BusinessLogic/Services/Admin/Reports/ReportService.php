<?php

namespace App\BusinessLogic\Services\Admin\Reports;

use App\Traits\ApiResponseMessage;
use App\BusinessLogic\Interfaces\Admin\Reports\ReportInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * ReportService is a service class the will implement all the methods from the ReportInterface contract and will handle the business logic.
 */
class ReportService implements ReportInterface
{
    use ApiResponseMessage;

    /**
     * Instantiate the variables that will be used to get the model and table name as well as the table's columns.
     * @return Collection|String|Integer
     */
    public function __construct()
    {
        //
    }

    /**
     * Fetch a single record from the database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id)
    {
        //
    }
}
