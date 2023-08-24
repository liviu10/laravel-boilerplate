<?php

namespace App\Library;

class DataModel
{
    protected $modelResults;
    protected $availableFields;
    protected $modelName;

    public function __construct($modelResults, $availableFields, $modelName)
    {
        $this->modelResults = $modelResults;
        $this->availableFields = $availableFields;
        $this->modelName = $modelName;
    }

    /**
     * Generate a data model based on provided model results and configuration.
     * @param string $type The type of data model ('column', 'model', or 'filter').
     * @param array $modelOptions Optional. Additional options for the data model. Default is an empty array.
     * @return array The generated data model as an array of field information.
     */
    public function generateDataModel($type, $modelOptions = []): Array
    {
        if ($this->modelResults && count($this->modelResults))
        {
            // Define $availableDataModel as empty array
            $availableDataModel = [];
            $dataModelId = 1;

            if (array_key_exists('total', $this->modelResults) && $this->modelResults['total'] !== 0)
            {
                if (array_key_exists('data', $this->modelResults))
                {
                    // Get all the fields from the $modelResults
                    $dataFields = $this->getFields($this->modelResults['data']);

                    // Get the filtered fields from $dataFields
                    $filteredDataFields = $this->getFilteredFields($dataFields, $this->availableFields);

                    return $this->getModelFields($type, $dataModelId, $filteredDataFields, $modelOptions, $availableDataModel);
                }
                else
                {
                    return [];
                }
            }
            else
            {
                // Get all the fields from the $modelResults
                $dataFields = $this->getFields($this->modelResults);

                // Get the filtered fields from $dataFields
                $filteredDataFields = $this->getFilteredFields($dataFields, $this->availableFields);

                return $this->getModelFields($type, $dataModelId, $filteredDataFields, $modelOptions, $availableDataModel);
            }
        }
        else
        {
            return [];
        }
    }

    /**
     * Extract and return a list of fields from the provided data.
     * @param array $data The data from which to extract field names.
     * @return array An array containing the extracted field names.
     */
    private function getFields($data): Array
    {
        $fields = [];
        foreach ($data as $field)
        {
            $fields = array_keys($field);
        }

        return $fields;
    }

    /**
     * Generate a translation string name based on the given string name, key, and type.
     * @param string $stringName The original string name to be formatted.
     * @param string $key The key or field for which to generate the translation string.
     * @param string $type The type of the data model ('column', 'model', or 'filter').
     * @return string The generated translation string name.
     */
    private function getTranslationStringName($stringName, $key, $type): String
    {
        $formattedTranslationString = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $stringName));
        $translationStringName = null;

        if ($key === 'id' || $key === 'created_at' || $key === 'updated_at' || $key === 'deleted_at')
        {
            $translationStringName = 'admin.generic.' . $type . '.' . $key;
        }
        else
        {
            $translationStringName = 'admin.' . $formattedTranslationString . '.' . $type . '.' . $key;
        }

        return $translationStringName;
    }

    /**
     * Generate column style properties based on the given key.
     * @param string $key The key or field for which to generate column style properties.
     * @return array An array containing the generated column style properties.
     */
    private function getColumnStyle($key): Array
    {
        $columnStyleProperties = [];
        if ($key === 'id')
        {
            $columnStyleProperties = [
                'style'       => 'width: 75px',
                'headerStyle' => 'width: 75px',
            ];
        }
        else
        {
            $columnStyleProperties = [
                'style'       => 'width: 100px',
                'headerStyle' => 'width: 100px',
            ];
        }

        return $columnStyleProperties;
    }

    /**
     * Filter and map fields based on their types and availability.
     * @param array $fields The list of fields to be filtered.
     * @param array $availableFields The available fields configuration.
     * @return array An array containing the filtered fields and their corresponding types.
     */
    private function getFilteredFields($fields, $availableFields): Array
    {
        $filteredFields = [];
        foreach ($fields as $field)
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
            if ($field === 'deleted_at')
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
     * Retrieve an array of model fields based on the given parameters.
     * @param string $type The type of data model ('column', 'model', or 'filter').
     * @param int $dataModelId The starting ID for the data models.
     * @param array $filteredDataFields An array of filtered data fields.
     * @param array $modelOptions An array of options for the data models.
     * @param array $availableDataModel An array to store the available data models.
     * @return array An array containing the available data models based on the provided parameters.
     */
    private function getModelFields($type, $dataModelId, $filteredDataFields = [], $modelOptions = [], $availableDataModel = []): Array
    {
        if ($type === 'column')
        {
            // Add actions column to $filteredDataFields
            $filteredDataFields += ['actions' => 'other'];

            // Construct the available data model based on $type = column
            foreach ($filteredDataFields as $key => $columnModel)
            {
                $model = [
                    'name'        => $key,
                    'label'       => $this->getTranslationStringName($this->modelName, $key, $type),
                    'field'       => $key,
                    'align'       => 'center',
                ];
                $dataModelId++;

                $model += $this->getColumnStyle($key);

                $availableDataModel[] = $model;
            }
        }

        if ($type === 'model' || $type === 'filter')
        {
            // Construct the available data model based on $type = filter
            foreach ($filteredDataFields as $key => $filterModel)
            {
                $model = [
                    'id'        => $dataModelId,
                    'is_active' => true,
                    'key'       => $key,
                    'name'      => $this->getTranslationStringName($this->modelName, $key, $type),
                    'type'      => $filterModel,
                    'value'     => null,
                ];
                $dataModelId++;

                if ($filterModel === 'select')
                {
                    $model['options'] = $this->getDataModelOptions($modelOptions[$key]);
                }

                if ($filterModel === 'boolean')
                {
                    $model['options'] = $this->getDataModelBooleanOptions();
                }

                $availableDataModel[] = $model;
            }
        }

        return $availableDataModel;
    }

    /**
     * Map and format data model options for select fields.
     * @param array $dataModelOptions The options to be formatted.
     * @return array An array containing the mapped and formatted data model options.
     */
    private function getDataModelOptions($dataModelOptions): Array
    {
        $mappedDataModelOptions = [];
        $optionId = 1;

        // foreach ($dataModelOptions as $option) {
        //     $optionValue = $optionId;
        //     $optionLabel = array_key_exists('id', $dataModelOptions) ? $option[array_keys($option)[1]] : $option;
        //     $mappedDataModelOptions[] = [
        //         'value' => $optionValue,
        //         'label' => $optionLabel,
        //     ];

        //     $optionId++;
        // }

        foreach ($dataModelOptions as $option) {
            $id = $option['id'];
            unset($option['id']);

            foreach ($option as $label) {
                $mappedDataModelOptions[] = [
                    'value' => $optionId,
                    'label' => $label,
                ];
                $optionId++;
            }
        }

        $dataModelOptions = $mappedDataModelOptions;

        return $dataModelOptions;
    }

    /**
     * Get boolean options for data model fields.
     * @return array An array containing boolean options for data model fields.
     */
    private function getDataModelBooleanOptions(): Array
    {
        $dataModelBooleanOptions = [
            [
                'value' => 0,
                'label' => 'No',
            ],
            [
                'value' => 1,
                'label' => 'Yes',
            ],
        ];

        return $dataModelBooleanOptions;
    }
}
