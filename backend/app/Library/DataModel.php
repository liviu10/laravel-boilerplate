<?php

namespace App\Library;

class DataModel
{
    protected $modelResults;
    protected $availableFields;
    protected $modelName;
    protected $statisticalIndicators;

    public function __construct($modelResults, $availableFields, $modelName, $statisticalIndicators)
    {
        $this->modelResults = $modelResults;
        $this->availableFields = $availableFields;
        $this->modelName = $modelName;
        $this->statisticalIndicators = $statisticalIndicators;
    }

    /**
     * Generate a data model based on provided model results and configuration.
     * @param string $type The type of data model ('column', 'model', or 'filter').
     * @param array $modelOptions Optional. Additional options for the data model. Default is an empty array.
     * @return array The generated data model as an array of field information.
     */
    public function generateDataModel($type, $modelOptions = []): array
    {
        if (!$this->modelResults || !count($this->modelResults))
        {
            return [];
        }

        $dataModelId = 1;
        $dataFields = array_key_exists('data', $this->modelResults)
            ? $this->getFields($this->modelResults['data'])
            : $this->getFields($this->modelResults);

        $filteredDataFields = $this->getFilteredFields($dataFields, $this->availableFields);

        return $this->getModelFields($type, $dataModelId, $filteredDataFields, $modelOptions, [], $this->statisticalIndicators);
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
    private function getTranslationStringName($stringName, $key, $type): string
    {
        $formattedTranslationString = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $stringName));

        $prefix = ($key === 'id' || $key === 'created_at' || $key === 'updated_at' || $key === 'deleted_at')
            ? 'admin.generic.'
            : 'admin.' . $formattedTranslationString . '.';

        return $prefix . $type . '.' . $key;
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
    private function getFilteredFields($fields, $availableFields): array
    {
        $filteredFields = [];

        foreach ($fields as $field) {
            $fieldTypes = [
                'id' => 'number',
                'created_at' => 'date',
                'updated_at' => 'date',
                'deleted_at' => 'date'
            ];

            if (isset($fieldTypes[$field]))
            {
                $filteredFields[$field] = $fieldTypes[$field];
            }
            elseif (isset($availableFields[$field]))
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
    private function getModelFields($type, $dataModelId, $filteredDataFields = [], $modelOptions = [], $availableDataModel = [], $statisticalIndicators = []): array
    {
        if ($type !== 'report')
        {
            foreach ($filteredDataFields as $key => $modelField) {
                if ($type !== 'report')
                {
                    $model = [
                        'id' => $dataModelId,
                        'name' => $this->getTranslationStringName($this->modelName, $key, $type),
                        'field' => $key,
                    ];

                    if ($type === 'column')
                    {
                        $model += $this->getColumnStyle($key);
                    }

                    if ($type === 'column')
                    {
                        $model['align'] = 'center';
                        $model['label'] = $model['name'];
                    }
                    elseif ($type === 'model' || $type === 'filter')
                    {
                        $model['is_active'] = true;
                        $model['key'] = $key;
                        $model['type'] = $modelField;
                        $model['value'] = null;

                        if ($modelField === 'select')
                        {
                            $model['options'] = $this->getDataModelOptions($modelOptions[$key]);
                        }
                        elseif ($modelField === 'boolean')
                        {
                            $model['options'] = $this->getDataModelBooleanOptions();
                        }
                    }

                    $dataModelId++;
                    $availableDataModel[] = $model;
                }
            }
        }
        else {
            foreach ($statisticalIndicators as $key => $indicatorValue) {
                $model = [
                    'id' => $dataModelId,
                    'name' => $this->getTranslationStringName($this->modelName, $key, $type),
                ];

                if (is_array($indicatorValue) && count($indicatorValue))
                {
                    if (array_key_exists('number', $indicatorValue) && array_key_exists('percentage', $indicatorValue))
                    {
                        $model += [
                            'value' => $indicatorValue['number'],
                            'percentage' => round($indicatorValue['percentage'], 2)
                        ];
                        if (array_key_exists('options', $indicatorValue)) {
                            $model += [
                                'options' => $indicatorValue['options']
                            ];
                        }
                    }
                    else
                    {
                        $options = [];
                        foreach ($indicatorValue as $subKey => $subValue) {
                            if (array_key_exists('number', $subValue) && array_key_exists('percentage', $subValue))
                            {
                                $options[] = [
                                    'key' => $subKey,
                                    'value' => $subValue['number'],
                                    'percentage' => round($subValue['percentage'], 2)
                                ];
                            }

                            if (array_key_exists('average', $subValue))
                            {
                                $options[count($options) - 1]['average'] = $subValue['average'];
                            }
                        }
                        $model['options'] = $options;
                    }
                }

                $dataModelId++;
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

        foreach ($dataModelOptions as $option) {
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
