<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ReportInterface;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class ReportController extends Controller
{
    protected ReportInterface $reportService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(ReportInterface $reportService)
    {
        $this->reportService = $reportService;
        parent::__construct(ReportInterface::class, ReportRequest::class);
    }

    public function getReport(Request $request): Response|ResponseFactory
    {
        return $this->reportService->handleGetReport($request->all());
    }
}
