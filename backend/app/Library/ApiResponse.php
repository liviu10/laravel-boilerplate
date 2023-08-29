<?php

namespace App\Library;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Library\DataModel;

class ApiResponse
{
    /**
     * Generate an API response based on the provided records, fields, and model name.
     * @param LengthAwarePaginator|Collection|array $records The records to be included in the response.
     * @param array|null $fields An array of fields to include in the response.
     * @param string|null $modelName The name of the model associated with the records.
     * @return Response|ResponseFactory The generated API response or response factory.
     */
    public function generateApiResponse(
        LengthAwarePaginator|Collection|array $records,
        array $fields = null,
        string $modelName = null,
        array $modelOptions = null
    ): Response|ResponseFactory
    {
        if ($records instanceof LengthAwarePaginator || $records instanceof Collection)
        {
            if ($records->isEmpty())
            {
                return $this->handleNotFoundResponse();
            }
            else
            {
                if (is_array($fields) && $modelName)
                {
                    $dataModel = new DataModel($records->toArray(), $fields, $modelName);
                    $apiDataModel = $dataModel->generateDataModel('model', is_array($modelOptions) ? $modelOptions : []);
                    $apiColumnModel = $dataModel->generateDataModel('column');
                    $apiFilterModel = $dataModel->generateDataModel('filter', is_array($modelOptions) ? $modelOptions : []);

                    return $this->handleSuccessResponse($records, $apiDataModel, $apiColumnModel, $apiFilterModel);
                }
                else
                {
                    return $this->handleSuccessResponse($records);
                }
            }
        }
        elseif (is_array($records))
        {
            if (count($records))
            {
                if (is_array($fields) && $modelName)
                {
                    $dataModel = new DataModel($records, $fields, $modelName);
                    $apiDataModel = $dataModel->generateDataModel('model');
                    $apiColumnModel = $dataModel->generateDataModel('column');
                    $apiFilterModel = $dataModel->generateDataModel('filter');

                    return $this->handleSuccessResponse($records, $apiDataModel, $apiColumnModel, $apiFilterModel);
                }
                else
                {
                    return $this->handleSuccessResponse($records);
                }
            }
            else
            {
                return $this->handleNotFoundResponse();
            }
        }
        else
        {
            return $this->handleErrorResponse();
        }
    }

    /**
     * Handle a response for a resource not found scenario.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleNotFoundResponse(): Response|ResponseFactory
    {
        $message = [
            'title'       => __('translations.not_found_message.title'),
            'description' => __('translations.not_found_message.description'),
        ];

        return response($message, 200);
    }

    /**
     * Handle a successful response for the API request.
     * @param LengthAwarePaginator|Collection|array $records The records to include in the response.
     * @param array|null $apiDataModel An array representing the data model information.
     * @param array|null $apiColumnModel An array representing the column model information.
     * @param array|null $apiFilterModel An array representing the filter model information.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleSuccessResponse(
        LengthAwarePaginator|Collection|array $records,
        array $apiDataModel = null,
        array $apiColumnModel = null,
        array $apiFilterModel = null,
    ): Response|ResponseFactory
    {
        $message = [
            'title'       => __('translations.ok_message.title'),
            'description' => __('translations.ok_message.description'),
            'results'     => $records,
        ];

        if (is_array($apiDataModel) && count($apiDataModel))
        {
            $message['models'] = $apiDataModel;
        }

        if (is_array($apiColumnModel) && count($apiColumnModel))
        {
            $message['columns'] = $apiColumnModel;
        }

        if (is_array($apiFilterModel) && count($apiFilterModel))
        {
            $message['filters'] = $apiFilterModel;
        }

        return response($message, 200);
    }

    /**
     * Handle an error response for the API request.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleErrorResponse(): Response|ResponseFactory
    {
        $message = [
            'title'       => __('translations.error_message.title'),
            'description' => __('translations.error_message.description'),
        ];

        return response($message, 500);
    }
}
