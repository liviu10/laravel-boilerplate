<?php

namespace App\Traits;

trait ApiSort
{
    public function handleApiSort($modelSort)
    {
        $availableSort = [];
        $sortId = 1;
        foreach ($modelSort as $index => $value) {
            $sort = [
                'id' => $sortId,
                'key' => $index,
                'options' => [
                    [
                        'value' => 1,
                        'label' => 'equals',
                        // 'value' => '='
                    ],
                    [
                        'value' => 2,
                        'label' => 'does not equal',
                        // 'value' => '<>'
                    ],
                    [
                        'value' => 3,
                        'label' => 'is greater than',
                        // 'value' => '>'
                    ],
                    [
                        'value' => 4,
                        'label' => 'is greater than or equal to',
                        // 'value' => '>='
                    ],
                    [
                        'value' => 5,
                        'label' => 'is less than',
                        // 'value' => '<'
                    ],
                    [
                        'value' => 6,
                        'label' => 'is less than or equal to',
                        // 'value' => '<='
                    ],
                    [
                        'value' => 7,
                        'label' => 'begins with',
                        // 'value' => 'LIKE'
                    ],
                    [
                        'value' => 8,
                        'label' => 'does not begins with',
                        // 'value' => 'NOT LIKE'
                    ],
                    [
                        'value' => 9,
                        'label' => 'ends with',
                        // 'value' => 'LIKE'
                    ],
                    [
                        'value' => 10,
                        'label' => 'does not ends with',
                        // 'value' => 'NOT LIKE'
                    ],
                    [
                        'value' => 11,
                        'label' => 'contains',
                        // 'value' => 'LIKE'
                    ],
                    [
                        'value' => 12,
                        'label' => 'does not contains',
                        // 'value' => 'NOT LIKE'
                    ]
                ],
                'value' => null
            ];

            $availableSort[] = $sort;
            $sortId++;
        }

        return $availableSort;
    }
}
