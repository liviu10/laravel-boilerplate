<?php

namespace App\Traits;

trait ApiOrder
{
    public function handleApiOrder($modelOrder)
    {
        $availableOrder = [];
        $orderId = 1;
        foreach ($modelOrder as $index => $value) {
            $order = [
                'id' => $orderId,
                'key' => $index,
                'options' => [
                    [
                        'value' => 1,
                        'label' => 'ascending',
                        // 'value' => 'ASC'
                    ],
                    [
                        'value' => 2,
                        'label' => 'descending',
                        // 'value' => 'DESC'
                    ],
                ],
                'value' => null
            ];

            $availableOrder[] = $order;
            $orderId++;
        }

        return $availableOrder;
    }
}
