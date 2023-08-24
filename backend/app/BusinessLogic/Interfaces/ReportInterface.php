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
     * @param array $search
     * @return \Illuminate\Http\Response
     */
    public function handleIndex($search);
}
