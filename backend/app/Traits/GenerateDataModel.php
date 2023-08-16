<?php

namespace App\Traits;

trait GenerateDataModel
{
    protected $fieldTypes = [
        'number',
        'textarea',
        'time',
        'text',
        'password',
        'email',
        'search',
        'tel',
        'file',
        'url',
        'date'
    ];

    public function generateApiDataModel($dataModel, $dataModelOptions = [])
    {
        $availableDataModel = [];
        $dataModelId = 1;
        foreach ($dataModel as $index => $value)
        {
            $model = [
                'id'        => $dataModelId,
                'is_active' => $this->setDataModelStatus($value),
                'is_field'  => false,
                'is_filter' => false,
                'key'       => $index,
                'type'      => $value,
                'value'     => null,
            ];

            $availableDataModel[] = $model;
            
            $dataModelId++;
        }
        dd($availableDataModel);

        return $availableDataModel;
    }

    public function setDataModelStatus($fieldType = null)
    {
        if (in_array($fieldType, $this->fieldTypes))
        {
            return false;
        }
        else{
            return true;
        }
    }
}
