<?php

namespace App\Traits;

trait ApiFilters
{
    /**
     * Handle API filters to generate an array of filter options.
     * This method takes an array of model filters and
     * an optional array of field types and generates an
     * array of filter options that can be used to filter the records.
     * @param array $modelFilters An array of model filters (keys to be used for filtering).
     * @param array $filterOptions An optional array of filter options.
     * @return array
     */
    public function handleApiFilters($modelFilters, $filterNames, $filterOptions = [])
    {
        $availableFilters = [];
        $filterId = 1;
        foreach ($modelFilters as $index => $value) {
            $filter = [
                'id' => $filterId,
                'key' => $index,
                'name' => isset($filterNames[$index]) ? $filterNames[$index] : 'Default filter name',
                'type' => $value,
                'value' => null,
            ];

            if ($value === 'select') {
                $options = isset($filterOptions[$index]) ? $filterOptions[$index] : [];
                $mappedOptions = [];
                $optionId = 1;
                foreach ($options as $option) {
                    $optionValue = $optionId;
                    $optionLabel = $option[array_keys($option->toArray())[1]];
                    $mappedOptions[] = [
                        'value' => $optionValue,
                        'label' => $optionLabel,
                    ];

                    $optionId++;
                }
                $filter['options'] = $mappedOptions;
            }

            $availableFilters[] = $filter;
            $filterId++;
        }

        return $availableFilters;
    }
}
