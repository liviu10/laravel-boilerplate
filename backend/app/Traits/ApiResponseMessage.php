<?php

namespace App\Traits;

trait ApiResponseMessage
{
    public function handleResponse(
        $responseType = null,
        $records = null,
        $dataModel = null,
        $columnModel = null,
        $filterModel = null
    )
    {
        if ($responseType === 'success')
        {
            $responseMessage = [
                'title'       => __('translations.ok_message.title'),
                'description' => __('translations.ok_message.description'),
            ];
            if ($records)
            {
                $responseMessage['results'] = $records;
            }
            if ($dataModel)
            {
                $responseMessage['model'] = $dataModel;
            }
            if ($columnModel)
            {
                $responseMessage['columns'] = $columnModel;
            }
            if ($filterModel)
            {
                $responseMessage['filters'] = $filterModel;
            }
        }
        elseif ($responseType === 'not_found')
        {
            $responseMessage = [
                'title'       => __('translations.not_found_message.title'),
                'description' => __('translations.not_found_message.description'),
            ];
        }
        else
        {
            $responseMessage = [
                'title'       => __('translations.not_ok_message.title'),
                'description' => __('translations.not_ok_message.description'),
            ];
        }

        return $responseMessage;
    }
}
