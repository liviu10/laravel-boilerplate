<?php

namespace App\Traits;

trait GenerateDataModel
{
    /**
     * Maps and retrieves options for a data model.
     * This method takes an array of options and maps them to a standardized format with
     * 'value' and 'label' attributes. Each option is given a unique value, and its label
     * is extracted from the input array. The mapped options are returned in an array.
     * @param array $options An array containing options to be mapped.
     * @return array An array containing mapped options with 'value' and 'label' attributes.
     */
    protected function getDataModelOptions($options): Array
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
    protected function getDataModelBooleanOptions(): Array
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
     * Generates an API data model based on available fields.
     * This method generates an API data model based on the provided list of available fields.
     * For each available field, a data model is created with attributes such as ID, key, name,
     * type, and value. If the field type is 'boolean', additional options are included.
     * @param array $availableFields An associative array of available fields and their data types.
     * @return array An array containing the generated API data model.
     */
    public function generateApiDataModel($availableFields, $dataModelOptions = []): Array
    {
        $availableDataModel = [];
        $dataModelId = 1;
        foreach ($availableFields as $key => $dataModel)
        {
            $model = [
                'id'        => $dataModelId,
                'is_active' => true,
                'key'       => $key,
                'name'      => $key,
                'type'      => $dataModel,
                'value'     => null,
            ];
            $dataModelId++;

            if ($dataModel === 'select')
            {
                $model['options'] = $this->getDataModelOptions($dataModelOptions);
            }

            if ($dataModel === 'boolean')
            {
                $model['options'] = $this->getDataModelBooleanOptions();
            }

            $availableDataModel[] = $model;
        }

        return $availableDataModel;
    }
}
