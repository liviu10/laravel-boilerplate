<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ApiStatisticalIndicators
{
    /**
     * Calculate statistical indicators based on API records.
     * @param Collection|array $apiAllRecordsDetails The collection or array of API records.
     * @param array $apiStatisticalIndicators The array of statistical indicators to calculate.
     * @param array|null $options Additional options to customize the calculation (optional).
     * @return array The calculated statistical indicators including counts, percentages, and options (if provided).
     */
    public function handleStatisticalIndicators(
        Collection|array $apiAllRecordsDetails,
        array $apiStatisticalIndicators,
        array|null $options = null
    ): array {
        $indicators = [];

        foreach ($apiStatisticalIndicators as $indicator) {
            $count = 0;
            $indicatorOptions = [];

            foreach ($apiAllRecordsDetails->toArray() as $record) {
                if (isset($record[$indicator]) && $record[$indicator] !== null) {
                    $count++;
                }
            }

            $indicatorData = [
                'number' => $count,
                'percentage' => round(($count / $apiAllRecordsDetails->count()) * 100, 2),
            ];

            if (isset($options[$indicator])) {
                $indicatorOptions = [];
                foreach ($options[$indicator] as $option) {
                    $count = $apiAllRecordsDetails->filter(function ($record) use ($option, $indicator) {
                        dd($record[$indicator], $option);
                        if ($indicator === 'is_active') {
                            return $record[$indicator] === (bool)$option['id'];
                        } else {
                            return $record[$indicator] === $option['id'];
                        }
                    })->count();

                    $indicatorOptions[] = [
                        'number' => $count,
                        'percentage' => round(($count / $apiAllRecordsDetails->count()) * 100, 2),
                    ];
                }

                $indicatorData['options'] = $indicatorOptions;
            }

            $indicators[$indicator] = $indicatorData;
        }

        $indicators['count'] = [
            'number' => $apiAllRecordsDetails->count(),
            'percentage' => null,
        ];

        return $indicators;
    }
}
