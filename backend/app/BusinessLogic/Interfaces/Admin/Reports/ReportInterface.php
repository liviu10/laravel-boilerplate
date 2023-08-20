<?php

namespace App\BusinessLogic\Interfaces\Admin\Reports;

/**
 * ReportInterface is a contract for what methods will be used in the ReportService class.
 * This consists of the following CRUD operations methods:
 * - handleShow();
 */
interface ReportInterface
{
    /**
     * Fetch a single record from the database.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id);
}
