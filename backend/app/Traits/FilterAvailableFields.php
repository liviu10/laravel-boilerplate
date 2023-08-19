<?php

namespace App\Traits;

trait FilterAvailableFields
{
    public function handleFilterAvailableFields($availableFields, $excludedFields = []): Array
    {
        $filterAvailableFields = [];
        foreach ($availableFields as $field => $type) {
            if ($excludedFields && count($excludedFields))
            {
                if (!in_array($field, $excludedFields)) {
                    $filterAvailableFields[$field] = $type;
                }
            }
            else
            {
                $filterAvailableFields[$field] = $type;
            }
        }

        return $filterAvailableFields;
    }
}
