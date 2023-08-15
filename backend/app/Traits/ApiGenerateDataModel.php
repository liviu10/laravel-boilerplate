<?php

namespace App\Traits;

use App\Models\Admin\Settings\Field;
use App\Models\Admin\Settings\Sort;

/**
 * This trait provides a method for generating filter model data for API.
 * @package App\Traits
 */
trait ApiGenerateDataModel
{
    /**
     * Generate filter model data for API based on provided information.
     * @param int $modelId The ID of the model.
     * @param object $model The model instance.
     * @param array<int, string> $fields An array containing field information.
     * @param array $modelOptions. An array containing model option information.
     * @return array The generated filter model data.
     */
    public function handleApiGenerateDataModel(int $modelId, $model, $fields, $modelOptions = [])
    {
        /**
         * Process and populate the fields payload:
         * If existing results are available, iterate through them and populate the fields payload.
         * Parameters:
         * @param array $results: An array containing existing results.
         * @param array $fieldsPayload: An array to store processed field data.
         * @param int $filterId: The starting ID for the filter.
         * If no existing results are available, iterate through provided fields information, populate the fields payload,
         * and create new model fields using the provided fields payload.
         * Parameters:
         * @param array $fields: An array containing field keys and types.
         * @param array $fieldsPayload: An array to store processed field data.
         * @param int $filterId: The starting ID for the filter.
         * @param  object $model: The model instance to create new fields for.
         * @param int $modelId: The ID of the model.
         * Reset field names and values in the fields payload.
         * Iterate through each field in the payload and set their 'name' and 'value' attributes to null.
         * Parameters:
         * @param array $fieldsPayload: An array containing field data to be reset.
         * @return array The processed fields payload.
         * @example [
         *  'id'        => 1,
         *  'key'       => 'key_name',
         *  'type'      => 'key_type', (eg: text, email, phone etc.)
         *  'is_field'  => 'false',
         *  'is_filter' => 'false',
         *  'is_active' => 'false',
         *  'name'      => null,
         *  'value'     => null,
         * ]
         */

        $fieldModel = new Field();
        $results = $fieldModel->where('fieldable_id', $modelId)->get()->toArray();
        $fieldsPayload = [];
        $filterId = 1;

        if ($results && count($results))
        {
            foreach ($results as $key => $value) {
                $fieldsPayload[] = [
                    'id'        => $filterId,
                    'key'       => $value['key'],
                    'type'      => $value['type'],
                    'is_field'  => $value['is_field'],
                    'is_filter' => $value['is_filter'],
                    'is_active' => $value['is_active'],
                ];
                $filterId++;
            }
        }
        else
        {
            foreach ($fields as $key => $type) {
                $fieldsPayload[] = [
                    'id'        => $filterId,
                    'key'       => $key,
                    'type'      => $type,
                    'is_field'  => false,
                    'is_filter' => false,
                    'is_active' => false,
                ];
                $filterId++;
            }
            $model->find($modelId)->field()->createMany($fieldsPayload);
        }

        $sortModel = new Sort();
        $results = $sortModel->where('sortable_id', $modelId)->get()->toArray();
        $sortsPayload = [];
        $sortId = 1;

        if ($results && count($results))
        {
            foreach ($results as $key => $value) {
                $sortsPayload[] = [
                    'id'        => $value['id'],
                    'field_id'  => $value['field_id'],
                    'value'     => $value['value'],
                    'label'     => $value['label'],
                    'is_order'  => $value['is_order'],
                    'is_sort'   => $value['is_sort'],
                    'is_active' => $value['is_active'],
                ];
            }
        }
        else
        {
            $orders = $this->getOrdering();
            $sorts = [];

            $sortId = 1;
            foreach ($fieldsPayload as $field) {
                foreach ($orders as $order) {
                    $sortsPayload[] = [
                        'id'        => $sortId,
                        'field_id'  => $field['id'],
                        'value'     => $order['value'],
                        'label'     => $order['label'],
                        'is_order'  => true,
                        'is_sort'   => false,
                        'is_active' => false,
                    ];
                }

                if ($field['type'] === 'number') {
                    $sorts = $this->getSortingNumber();
                    foreach ($sorts as $sort) {
                        $sortsPayload[] = [
                            'id'        => $sortId,
                            'field_id'  => $field['id'],
                            'value'     => $sort['value'],
                            'label'     => $sort['label'],
                            'is_order'  => false,
                            'is_sort'   => true,
                            'is_active' => false,
                        ];
                    }
                }

                if ($field['type'] === 'text' || $field['type'] === 'email' || $field['type'] === 'search' || $field['type'] === 'tel') {
                    $sorts = $this->getSortingText();
                    foreach ($sorts as $sort) {
                        $sortsPayload[] = [
                            'id'        => $sortId,
                            'field_id'  => $field['id'],
                            'value'     => $sort['value'],
                            'label'     => $sort['label'],
                            'is_order'  => false,
                            'is_sort'   => true,
                            'is_active' => false,
                        ];
                    }
                }

                if ($field['type'] === 'date' || $field['type'] === 'time') {
                    $sorts = $this->getSortingDate();
                    foreach ($sorts as $sort) {
                        $sortsPayload[] = [
                            'id'        => $sortId,
                            'field_id'  => $field['id'],
                            'value'     => $sort['value'],
                            'label'     => $sort['label'],
                            'is_order'  => false,
                            'is_sort'   => true,
                            'is_active' => false,
                        ];
                    }
                }

                if ($field['type'] === 'boolean') {
                    $sorts = $this->getSortingBoolean();
                    foreach ($sorts as $sort) {
                        $sortsPayload[] = [
                            'id'        => $sortId,
                            'field_id'  => $field['id'],
                            'value'     => $sort['value'],
                            'label'     => $sort['label'],
                            'is_order'  => false,
                            'is_sort'   => true,
                            'is_active' => false,
                        ];
                    }
                }

                if ($field['type'] === 'select') {
                    if ($field['key'] === 'is_active') {
                        $sorts = $this->getSortingBoolean();
                        foreach ($sorts as $sort) {
                            $sortsPayload[] = [
                                'id'        => $sortId,
                                'field_id'  => $field['id'],
                                'value'     => $sort['value'],
                                'label'     => $sort['label'],
                                'is_order'  => false,
                                'is_sort'   => true,
                                'is_active' => false,
                            ];
                        }
                    }

                    if ($modelOptions && count($modelOptions)) {
                        if ($field['key'] === 'options') {
                            $sorts = $modelOptions;
                            foreach ($sorts as $sort) {
                                $sortsPayload[] = [
                                    'id'        => $sortId,
                                    'field_id'  => $field['id'],
                                    'value'     => $sort['value'],
                                    'label'     => $sort['label'],
                                    'is_order'  => false,
                                    'is_sort'   => true,
                                    'is_active' => false,
                                ];
                            }
                        }
                    }
                }

                $sortId++;
            }
            $model->find($modelId)->sort()->createMany($sortsPayload);
        }

        foreach ($fieldsPayload as &$field) {
            $field['name'] = null;
            $field['value'] = null;
            $field['sort'] = array_filter($sortsPayload, function($value) use ($field) {
                return $value['field_id'] === $field['id'];
            });
        }

        return $fieldsPayload;
    }

    protected function getOrdering()
    {
        $orders = [
            [
                'value' => '1',
                'label' => 'Ascending',
            ],
            [
                'value' => '2',
                'label' => 'Descending',
            ],
        ];

        return $orders;
    }

    protected function getSortingNumber()
    {
        $sorts = [
            [
                'value' => '1',
                'label' => 'Equals',
            ],
            [
                'value' => '2',
                'label' => 'Does not equal',
            ],
            [
                'value' => '3',
                'label' => 'Greater than',
            ],
            [
                'value' => '4',
                'label' => 'Greater than or equal to',
            ],
            [
                'value' => '5',
                'label' => 'Less than',
            ],
            [
                'value' => '6',
                'label' => 'Less than or equal to',
            ]
        ];

        return $sorts;
    }

    protected function getSortingText()
    {
        $sorts = [
            [
                'value' => '1',
                'label' => 'Starts with',
            ],
            [
                'value' => '2',
                'label' => 'Ends with',
            ],
            [
                'value' => '3',
                'label' => 'Contains',
            ],
            [
                'value' => '4',
                'label' => 'Does not contains',
            ],
            [
                'value' => '5',
                'label' => 'Equals',
            ],
            [
                'value' => '6',
                'label' => 'Does not equals',
            ]
        ];

        return $sorts;
    }

    protected function getSortingDate()
    {
        $sorts = [
            [
                'value' => '1',
                'label' => 'On',
            ],
            [
                'value' => '2',
                'label' => 'Not on',
            ],
            [
                'value' => '3',
                'label' => 'After',
            ],
            [
                'value' => '4',
                'label' => 'Before',
            ],
            [
                'value' => '5',
                'label' => 'Today',
            ],
            [
                'value' => '6',
                'label' => 'Yesterday',
            ],
            [
                'value' => '7',
                'label' => 'This month',
            ],
            [
                'value' => '8',
                'label' => 'Last month',
            ],
            [
                'value' => '9',
                'label' => 'Next month',
            ],
            [
                'value' => '10',
                'label' => 'This year',
            ],
            [
                'value' => '11',
                'label' => 'Last year',
            ],
            [
                'value' => '12',
                'label' => 'Next year',
            ]
        ];

        return $sorts;
    }

    protected function getSortingBoolean()
    {
        $sorts = [
            [
                'value' => '1',
                'label' => 'Yes',
            ],
            [
                'value' => '2',
                'label' => 'No',
            ]
        ];

        return $sorts;
    }
}
