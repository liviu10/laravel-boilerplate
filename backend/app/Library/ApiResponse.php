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
     * @param array|null $modelOptions The options of the model associated with the records.
     * @param array|null $statisticalIndicators The reports of the model associated with the records.
     * @return Response|ResponseFactory The generated API response or response factory.
     */
    public function generateApiResponse(
        LengthAwarePaginator|Collection|array $records,
        string $actionMethod = 'get' | 'create' | 'update' | 'delete',
        array $fields = null,
        string $modelName = null,
        array $modelOptions = null,
        array $statisticalIndicators = null,
    ): Response|ResponseFactory
    {
        if ($records instanceof LengthAwarePaginator || $records instanceof Collection)
        {
            if ($records->isEmpty())
            {
                return $this->handleNotFoundResponse($actionMethod);
            }
            else
            {
                if (is_array($fields) && $modelName)
                {
                    $dataModel = new DataModel(
                        $records->toArray(),
                        $fields,
                        $modelName,
                        is_array($statisticalIndicators) && count($statisticalIndicators) ? $statisticalIndicators : []
                    );
                    $apiDataModel = $dataModel->generateDataModel(
                        'model',
                        is_array($modelOptions) && count($modelOptions) ? $modelOptions : []
                    );
                    $apiColumnModel = $dataModel->generateDataModel('column');
                    $apiFilterModel = $dataModel->generateDataModel(
                        'filter',
                        is_array($modelOptions) && count($modelOptions) ? $modelOptions : []
                    );
                    $apiStatisticalIndicators = $dataModel->generateDataModel('report');

                    return $this->handleSuccessResponse(
                        $records,
                        $actionMethod,
                        $apiDataModel,
                        $apiColumnModel,
                        $apiFilterModel,
                        $apiStatisticalIndicators
                    );
                }
                else
                {
                    return $this->handleSuccessResponse($records, $actionMethod);
                }
            }
        }
        elseif (is_array($records))
        {
            if (count($records))
            {
                if (is_array($fields) && $modelName)
                {
                    $dataModel = new DataModel(
                        $records,
                        $fields,
                        $modelName,
                        is_array($statisticalIndicators) && count($statisticalIndicators) ? $statisticalIndicators : []
                    );
                    $apiDataModel = $dataModel->generateDataModel(
                        'model',
                        is_array($modelOptions) && count($modelOptions) ? $modelOptions : []
                    );
                    $apiColumnModel = $dataModel->generateDataModel('column');
                    $apiFilterModel = $dataModel->generateDataModel(
                        'filter',
                        is_array($modelOptions) && count($modelOptions) ? $modelOptions : []
                    );
                    $apiStatisticalIndicators = $dataModel->generateDataModel('report');

                    return $this->handleSuccessResponse(
                        $records,
                        $actionMethod,
                        $apiDataModel,
                        $apiColumnModel,
                        $apiFilterModel,
                        $apiStatisticalIndicators
                    );
                }
                else
                {
                    return $this->handleSuccessResponse($records, $actionMethod);
                }
            }
            else
            {
                return $this->handleNotFoundResponse($actionMethod);
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
    private function handleNotFoundResponse(string $actionMethod = 'get' | 'create' | 'update' | 'delete'): Response|ResponseFactory
    {
        $message = [
            'title'       => __('translations.not_found_message.title'),
            'description' => __('translations.not_found_message.description'),
        ];

        return response($message, 404);
    }

    /**
     * Handle a successful response for the API request.
     * @param LengthAwarePaginator|Collection|array $records The records to include in the response.
     * @param array|null $apiDataModel An array representing the data model information.
     * @param array|null $apiColumnModel An array representing the column model information.
     * @param array|null $apiFilterModel An array representing the filter model information.
     * @param array|null $apiStatisticalIndicators An array representing the reports model information.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleSuccessResponse(
        LengthAwarePaginator|Collection|array $records,
        string $actionMethod = 'get' | 'create' | 'update' | 'delete',
        array $apiDataModel = null,
        array $apiColumnModel = null,
        array $apiFilterModel = null,
        array $apiStatisticalIndicators = null
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

        if (is_array($apiStatisticalIndicators) && count($apiStatisticalIndicators))
        {
            $message['reports'] = $apiStatisticalIndicators;
        }

        return response($message, $actionMethod === 'create' ? 201 : 200);
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
