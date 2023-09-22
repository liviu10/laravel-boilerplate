<?php

namespace App\BusinessLogic\Interfaces;

interface ResourceInterface
{
    public function handleComponentDetails(string $path): array;
}
