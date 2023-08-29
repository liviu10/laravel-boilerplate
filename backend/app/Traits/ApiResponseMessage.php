<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

trait ApiResponseMessage
{

    public function handleResponse(
        string $responseType = 'success' | 'not_found' | 'warning' | 'error',
        LengthAwarePaginator|Collection|array $records,
        array $dataModel = null,
        array $columnModel = null,
        array $filterModel = null
    ): Array
    {
        return $this->handleAttachResponse($responseType, $records, $dataModel, $columnModel, $filterModel);


        // if ($responseType === 'success')
        // {
        //     $responseMessage = [
                // 'title'       => __('translations.ok_message.title'),
                // 'description' => __('translations.ok_message.description'),
        //     ];
        //     if ($records)
        //     {
        //         $responseMessage['results'] = $records;
        //     }
        //     if ($dataModel)
        //     {
        //         $responseMessage['model'] = $dataModel;
        //     }
        //     if ($columnModel)
        //     {
        //         $responseMessage['columns'] = $columnModel;
        //     }
        //     if ($filterModel)
        //     {
        //         $responseMessage['filters'] = $filterModel;
        //     }
        // }
        // elseif ($responseType === 'not_found')
        // {
        //     $responseMessage = [
                // 'title'       => __('translations.not_found_message.title'),
                // 'description' => __('translations.not_found_message.description'),
        //     ];
        // }
        // elseif ($responseType === 'warning')
        // {
        //     $responseMessage = [
        //         'title'       => __('translations.warning_message.title'),
        //         'description' => __('translations.warning_message.description'),
        //     ];
        // }
        // else
        // {
        //     $responseMessage = [
        //         'title'       => __('translations.not_ok_message.title'),
        //         'description' => __('translations.not_ok_message.description'),
        //     ];
        // }

        // return $responseMessage;
    }

    private function handleAttachResponse(
        string $responseType = 'success' | 'not_found' | 'warning' | 'error',
        LengthAwarePaginator|Collection|array $records,
        array $dataModel = null,
        array $columnModel = null,
        array $filterModel = null
    )
    {
        $response = [];

        switch ($responseType)
        {
            case 'success':
                $response = [
                    'title'       => __('translations.ok_message.title'),
                    'description' => __('translations.ok_message.description'),
                ];

                if ($records instanceof LengthAwarePaginator || is_array($records))
                {
                    $response['results'] = $records;
                }
                else
                {
                    $response['results'] = [];
                }

                if (is_array($dataModel))
                {
                    $response['models'] = $dataModel;
                }
                else
                {
                    $response['models'] = [];
                }

                if (is_array($columnModel))
                {
                    $response['columns'] = $columnModel;
                }
                else
                {
                    $response['columns'] = [];
                }

                if (is_array($filterModel))
                {
                    $response['filters'] = $filterModel;
                }
                else
                {
                    $response['filters'] = [];
                }

                return $response;
            case 'not_found':
                $response = [
                    'title'       => __('translations.not_found_message.title'),
                    'description' => __('translations.not_found_message.description'),
                ];

                return $response;
            case 'warning':
                $response = [
                    'title'       => __('translations.warning_message.title'),
                    'description' => __('translations.warning_message.description'),
                ];

                return $response;
            case 'error':
                $response = [
                    'title'       => __('translations.error_message.title'),
                    'description' => __('translations.error_message.description'),
                ];

                return $response;
            default:
                dd(is_array($records));
                return false;
        }
    }
}
