<?php

namespace App\Traits;

/**
 *  ApiResponseMessage is a trait the will used by all the service classes.
 */
trait ApiResponseMessage
{
    /**
     * Handle the API response.
     * This function generates an API response based on the specified response type and
     * optional records and filters data.
     * @param string|null $responseType (Optional) The type of response to generate. Possible values are:
     * - "success": For successful responses.
     * - "not_found": For resource not found responses.
     * If not provided or null, it will generate a default error response.
     * @param mixed|null  $records (Optional) An optional array of records to include in the response.
     * Should be provided when $responseType is "success".
     * @param mixed|null  $filters (Optional) An optional array of filters to include in the response.
     * Should be provided when $responseType is "success".
     */
    public function handleResponse($responseType = null, $records = null, $dataModel = null, $filters = null)
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
            if ($filters)
            {
                $responseMessage['filters'] = $filters;
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
