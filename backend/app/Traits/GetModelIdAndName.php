<?php

namespace App\Traits;

trait GetModelIdAndName
{
    public function handleModelIdAndName(int $modelId, string $modelName): Array
    {
        return [
            $modelId,
            $modelName
        ];
    }
}
