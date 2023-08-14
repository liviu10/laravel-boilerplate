<?php

namespace App\Traits;

trait ApiDataModel
{
    public function handleApiDataModel($dataModel, $dataModelOptions)
    {
        $availableDataModel = [];
        $dataModelId = 1;
        foreach ($dataModel as $index => $value) {
            $isName = isset($dataModelOptions[$index]) && isset($dataModelOptions[$index]['name']);
            $isRequired = isset($dataModelOptions[$index]) && isset($dataModelOptions[$index]['is_required']);
            if ($isRequired) {
                $model = [
                    'id' => $dataModelId,
                    'key' => $index,
                    'name' => $isName ? $dataModelOptions[$index]['name'] : 'Default input name',
                    'type' => $value,
                    'required' => $isRequired ? $dataModelOptions[$index]['is_required'] : false,
                    'value' => null,
                    'rules' => $index
                ];

                $availableDataModel[] = $model;
                $dataModelId++;
            }

            dd($dataModelOptions);
        }

        return $availableDataModel;
    }
}
