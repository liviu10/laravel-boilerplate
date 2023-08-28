<?php

namespace App\BusinessLogic\Interfaces;

/**
 * ReportInterface is a contract for what methods will be used in the ReportService class.
 * This consists of the following CRUD operations methods:
 * - handleShow();
 */
interface ReportInterface
{
    /**
     * Fetch all the records from the database.
     * @return \Illuminate\Http\Response
     */
    public function handleIndex();

    /**
     * Fetch a single record from the database.
     * @param int $reportableId
     * @return \Illuminate\Http\Response
     */
    public function handleShow($reportableId);
}
