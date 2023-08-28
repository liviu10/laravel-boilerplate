<?php

namespace App\Traits;

trait ApiReportAction
{
    public function handleReportAction(int $modelId, array $statisticalIndicators)
    {
        dd($statisticalIndicators);
    }
}
