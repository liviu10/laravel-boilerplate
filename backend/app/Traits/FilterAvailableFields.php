<?php

namespace App\Traits;

trait FilterAvailableFields
{
    /**
     * Filter available fields based on exclusion criteria.
     * @param array $availableFields An array of available fields where keys represent field names and values represent field types.
     * @param array $excludedFields An array of field names to be excluded from the available fields (optional).
     * @return array The filtered available fields after applying the exclusion criteria.
     */
    public function handleFilterAvailableFields(array $availableFields, array $excludedFields = []): array
    {
        $filterAvailableFields = [];
        foreach ($availableFields as $field => $type) {
            if ($excludedFields && count($excludedFields)) {
                if (!in_array($field, $excludedFields)) {
                    $filterAvailableFields[$field] = $type;
                }
            } else {
                $filterAvailableFields[$field] = $type;
            }
        }

        return $filterAvailableFields;
    }
}
