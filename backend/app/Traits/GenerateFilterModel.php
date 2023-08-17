<?php

namespace App\Traits;

trait GenerateFilterModel
{
    /**
     * Retrieves an array of data fields from the input data.
     * This method takes an array of data and extracts the keys of each associative
     * array within the input data. It returns an array containing all the unique
     * keys found in the input data arrays.
     * @param array $data The input data containing associative arrays.
     * @return array An array containing unique keys from the input data arrays.
     */
    protected function getDataFields($data): Array
    {
        $dataFields = [];
        foreach ($data as $field)
        {
            $dataFields = array_keys($field);
        }

        return $dataFields;
    }

    /**
     * Filters and maps data fields based on available fields and predefined rules.
     * This method takes an array of data fields and filters them based on available fields
     * and predefined rules. Certain fields like 'id', 'created_at', and 'updated_at' are
     * given specific data types. Additionally, the method checks if a field is available in
     * the list of available fields and maps it accordingly.
     * @param array $dataFields An array containing data fields to be filtered.
     * @param array $availableFields An associative array of available fields and their data types.
     * @return array An array containing filtered data fields mapped to their corresponding data types.
     */
    protected function getFilteredFields($dataFields, $availableFields): Array
    {
        $filteredFields = [];
        foreach ($dataFields as $field)
        {
            if ($field === 'id')
            {
                $filteredFields[$field] = 'number';
            }
            if ($field === 'created_at')
            {
                $filteredFields[$field] = 'date';
            }
            if ($field === 'updated_at')
            {
                $filteredFields[$field] = 'date';
            }
            if (isset($availableFields[$field]))
            {
                $filteredFields[$field] = $availableFields[$field];
            }
        }

        return $filteredFields;
    }

    /**
     * Maps and retrieves options for a filter model.
     * This method takes an array of options and maps them to a standardized format with
     * 'value' and 'label' attributes. Each option is given a unique value, and its label
     * is extracted from the input array. The mapped options are returned in an array.
     * @param array $options An array containing options to be mapped.
     * @return array An array containing mapped options with 'value' and 'label' attributes.
     */
    protected function getFilterModelOptions($options): Array
    {
        $mappedOptions = [];
        $optionId = 1;
        foreach ($options as $option) {
            $optionValue = $optionId;
            $optionLabel = $option[array_keys($option)[1]];
            $mappedOptions[] = [
                'value' => $optionValue,
                'label' => $optionLabel,
            ];

            $optionId++;
        }
        $options = $mappedOptions;

        return $options;
    }

    /**
     * Retrieves an array of boolean filter options.
     * This method returns an array of boolean filter options, where each option is represented
     * by a value and its corresponding label. The options typically represent boolean values
     * such as 'Yes' and 'No'.
     * @return array An array containing boolean filter options.
     */
    protected function getFilterBooleanOptions(): Array
    {
        $options = [
            [
                'value' => 0,
                'label' => 'No',
            ],
            [
                'value' => 1,
                'label' => 'Yes',
            ],
        ];

        return $options;
    }

    /**
     * Generates an API filter model based on input data and available fields.
     * This method generates an API filter model based on the provided input data and the list
     * of available fields. It extracts data fields from the input data, filters them based on
     * the available fields, and creates a filter model for each filtered field. The filter model
     * includes an ID, key, name, type, and other relevant attributes.
     * @param array $data An array containing input data for generating the filter model.
     * @param array $availableFields An associative array of available fields and their data types.
     * @return array An array containing the generated API filter model.
     */
    public function generateApiFilterModel($data, $availableFields, $filterModelOptions = []): Array
    {
        if ($data && count($data))
        {
            if (array_key_exists('total', $data) && $data['total'] !== 0)
            {
                if (array_key_exists('data', $data))
                {
                    $dataFields = $this->getDataFields($data['data']);

                    $filteredDataFields = $this->getFilteredFields($dataFields, $availableFields);

                    $availableFilterModel = [];
                    foreach ($filteredDataFields as $key => $filter)
                    {
                        $filterId = 1;
                        $model = [
                            'id'        => $filterId,
                            'is_active' => true,
                            'key'       => $key,
                            'name'      => $key,
                            'type'      => $filter,
                            'value'     => null,
                        ];
                        $filterId++;

                        if ($filter === 'select')
                        {
                            $model['options'] = $this->getFilterModelOptions($filterModelOptions);
                        }

                        if ($filter === 'boolean')
                        {
                            $model['options'] = $this->getFilterBooleanOptions();
                        }

                        $availableFilterModel[] = $model;
                    }

                    return $availableFilterModel;
                }
                else
                {
                    return [];
                }
            }
            else
            {
                return [];
            }
        }
        else
        {
            return [];
        }
    }
}
