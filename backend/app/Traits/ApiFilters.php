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
        $orderId = 1;
        $sortId = 1;
        foreach ($modelFilters as $index => $value) {
            $filter = [
                'id' => $filterId,
                'key' => $index,
                'name' => isset($filterNames[$index]) ? $filterNames[$index] : 'Default filter name',
                'type' => $value,
                'value' => null,
                'order' => [
                    'id' => $orderId,
                    'value' => null,
                    'options' => [
                        [
                            'value' => 1,
                            'label' => 'Ascending',
                            'icon'  => 'fa-solid fa-arrow-up-a-z',
                        ],
                        [
                            'value' => 2,
                            'label' => 'Descending',
                            'icon'  => 'fa-solid fa-arrow-up-z-a',
                        ],
                    ]
                    ],
                'sort' => [
                    'id' => $sortId,
                    'value' => null,
                    'options' => []
                ],
            ];

            // Add sort options for filter number type
            if ($value === 'number') {
                $filter['sort']['options'] = [
                    [
                        'value' => 1,
                        'label' => 'Equals',
                        'icon'  => 'fa-solid fa-equals',
                    ],
                    [
                        'value' => 2,
                        'label' => 'Does not equal',
                        'icon'  => 'fa-solid fa-not-equals',
                    ],
                    [
                        'value' => 3,
                        'label' => 'Greater than',
                        'icon'  => 'fa-solid fa-greater-than',
                    ],
                    [
                        'value' => 4,
                        'label' => 'Greater than or equal to',
                        'icon'  => 'fa-solid fa-greater-than-equal',
                    ],
                    [
                        'value' => 5,
                        'label' => 'Less than',
                        'icon'  => 'fa-solid fa-less-than',
                    ],
                    [
                        'value' => 6,
                        'label' => 'Less than or equal to',
                        'icon'  => 'fa-solid fa-less-than-equal',
                    ]
                ];
            }

            // Add sort options for filter text type
            if ($value === 'text') {
                $filter['sort']['options'] = [
                    [
                        'value' => 1,
                        'label' => 'Starts with',
                        'icon'  => 'last_page',
                    ],
                    [
                        'value' => 2,
                        'label' => 'Ends with',
                        'icon'  => 'last_page',
                    ],
                    [
                        'value' => 3,
                        'label' => 'Contains',
                        'icon'  => 'fa-regular fa-square-check',
                    ],
                    [
                        'value' => 4,
                        'label' => 'Does not contains',
                        'icon'  => 'check_box_outline_blank',
                    ],
                    [
                        'value' => 5,
                        'label' => 'Equals',
                        'icon'  => 'fa-solid fa-equals',
                    ],
                    [
                        'value' => 6,
                        'label' => 'Does not equals',
                        'icon'  => 'fa-solid fa-not-equals',
                    ]
                ];
            }

            // Add sort options for filter date type
            if ($value === 'date') {
                $filter['sort']['options'] = [
                    [
                        'value' => 1,
                        'label' => 'On',
                        'icon'  => '',
                    ],
                    [
                        'value' => 2,
                        'label' => 'Not on',
                        'icon'  => '',
                    ],
                    [
                        'value' => 3,
                        'label' => 'After',
                        'icon'  => '',
                    ],
                    [
                        'value' => 4,
                        'label' => 'Before',
                        'icon'  => '',
                    ],
                    [
                        'value' => 5,
                        'label' => 'Today',
                        'icon'  => '',
                    ],
                    [
                        'value' => 6,
                        'label' => 'Yesterday',
                        'icon'  => '',
                    ],
                    [
                        'value' => 7,
                        'label' => 'This month',
                        'icon'  => '',
                    ],
                    [
                        'value' => 8,
                        'label' => 'Last month',
                        'icon'  => '',
                    ],
                    [
                        'value' => 9,
                        'label' => 'Next month',
                        'icon'  => '',
                    ],
                    [
                        'value' => 10,
                        'label' => 'This year',
                        'icon'  => '',
                    ],
                    [
                        'value' => 11,
                        'label' => 'Last year',
                        'icon'  => '',
                    ],
                    [
                        'value' => 12,
                        'label' => 'Next year',
                        'icon'  => '',
                    ]
                ];
            }

            // Add sort options for filter boolean type
            if ($value === 'boolean') {
                $filter['sort']['options'] = [
                    [
                        'value' => 1,
                        'label' => 'Yes',
                        'icon'  => 'fa-solid fa-check',
                    ],
                    [
                        'value' => 2,
                        'label' => 'No',
                        'icon'  => 'fa-solid fa-xmark',
                    ]
                ];
            }

            // Add options for filter select type
            if ($value === 'select') {
                if ($index === 'is_active') {
                    $filter['options'] = [
                        [
                            'value' => 0,
                            'label' => 'No',
                        ],
                        [
                            'value' => 1,
                            'label' => 'Yes',
                        ],
                    ];
                }
                else {
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
            }

            $availableFilters[] = $filter;
            $filterId++;
            $orderId++;
            $sortId++;
        }

        return $availableFilters;
    }
}
