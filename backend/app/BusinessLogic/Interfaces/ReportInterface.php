<?php

namespace App\BusinessLogic\Interfaces;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

interface ReportInterface
{
    public function handleGetReport(array $key): Response|ResponseFactory;
}
