<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\ReportInterface;

class ReportController extends Controller
{
    protected ReportInterface $reportService;

    /**
     * Instantiate the interface that will be used to get all the methods that are going to be used in this controller.
     */
    public function __construct(ReportInterface $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Fetch all the records from the database. HTTP request [GET].
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->reportService->handleIndex();
    }

    /**
     * Display the specified resource. HTTP request [GET].
     * @param  int  $reportableId
     * @return \Illuminate\Http\Response
     */
    public function show($reportableId)
    {
        return $this->reportService->handleShow($reportableId);
    }
}
