<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLogic\Interfaces\Admin\Reports\ReportInterface;

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
     * Display the specified resource. HTTP request [GET].
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->reportService->handleShow($id);
    }
}
