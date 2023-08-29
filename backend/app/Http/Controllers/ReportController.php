<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Interfaces\ReportInterface;

class ReportController extends Controller
{
    protected ReportInterface $reportService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ReportInterface::class);
    }
}
