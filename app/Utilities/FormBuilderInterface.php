<?php

namespace App\Utilities;
use Illuminate\Database\Eloquent\Collection;
use Exception;

interface FormBuilderInterface
{
    public function handleFormBuilder(array $inputs): array;

    public function handlePopulateInput(Collection|Exception $selectedRecord, array $inputs): array;
}
