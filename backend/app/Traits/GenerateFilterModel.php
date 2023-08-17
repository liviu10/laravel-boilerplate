<?php

namespace App\Traits;

trait GenerateFilterModel
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

    public function generateApiFilterModel($dataModel, $fields): Array
    {
        if ($dataModel && count($dataModel))
        {
            if (array_key_exists('total', $dataModel) && $dataModel['total'] !== 0)
            {
                if (array_key_exists('data', $dataModel))
                {
                    // $fields = [
                    //     "full_name" => "text",
                    //     "first_name" => "text",
                    //     "last_name" => "text",
                    //     "nickname" => "text",
                    //     "email" => "email",
                    //     "phone" => "tel",
                    //     "password" => "password",
                    //     "profile_image" => "file",
                    //     "role_id" => "number",
                    // ];
                    // $dataModel['data'] = [
                    //     0 => [
                    //     "id" => 1,
                    //     "full_name" => "User Webmaster",
                    //     "nickname" => "webmaster",
                    //     "email" => "webmaster@localhost.com",
                    //     "created_at" => "17.08.2023 03:54",
                    //     ],
                    //     1 => array:5 [▶],
                    //     2 => array:5 [▶],
                    //     3 => array:5 [▶],
                    //     4 => array:5 [▶],
                    // ];
                    $availableFilterModel = [];
                    foreach ($dataModel['data'] as $filter)
                    {
                        $model = [
                            'id'        => $filter['id'],
                            'is_active' => true,
                            'is_field'  => false,
                            'is_filter' => false,
                            'key'       => '',
                            'value'     => null,
                            'type'      => isset($filter['type']) && in_array($filter['type'], $this->fieldTypes) ? $filter['type'] : 'text'
                        ];
                        $availableFilterModel[] = $model;
                    }
                    return $availableFilterModel;
                }
                else
                {

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
