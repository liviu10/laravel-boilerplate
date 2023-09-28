<?php

namespace App\BusinessLogic\Interfaces;

interface AcceptedDomainInterface
{
    public function handleStatisticalIndicators(): array;

    public function handleResources(array $resources): array;
}
