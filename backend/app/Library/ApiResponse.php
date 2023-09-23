<?php

namespace App\Library;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Library\DataModel;

enum Actions
{
    case get;
    case create;
    case update;
    case delete;
    case not_allowed;
    case not_found_record;
}

class ApiResponse
{
    /**
     * Generate an API response based on the provided records, fields, and model name.
     * @param LengthAwarePaginator|Collection|array|null $records The records to be included in the response.
     * @param Actions $action A string that refers to the action method.
     * @param array|null $fields An array of fields to include in the response.
     * @param string|null $modelName The name of the model associated with the records.
     * @param array|null $modelOptions The options of the model associated with the records.
     * @param array|null $statisticalIndicators The reports of the model associated with the records.
     * @return Response|ResponseFactory The generated API response or response factory.
     */
    public function generateApiResponse(
        LengthAwarePaginator|Collection|array|null $records = null,
        Actions $action,
        array $fields = null,
        string $modelName = null,
        array $modelOptions = null,
        array $statisticalIndicators = null,
    ): Response|ResponseFactory {
        if ($records instanceof LengthAwarePaginator || $records instanceof Collection) {
            if ($records->isEmpty()) {
                return $this->handleNotFoundResponse($action);
            } else {
                if (is_array($fields) && $modelName) {
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
                        $action,
                        $apiDataModel,
                        $apiColumnModel,
                        $apiFilterModel,
                        $apiStatisticalIndicators
                    );
                } else {
                    return $this->handleSuccessResponse($records, $action);
                }
            }
        } elseif (is_array($records)) {
            if (count($records)) {
                if (is_array($fields) && $modelName) {
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
                        $action,
                        $apiDataModel,
                        $apiColumnModel,
                        $apiFilterModel,
                        $apiStatisticalIndicators
                    );
                } else {
                    return $this->handleSuccessResponse($records, $action);
                }
            } else {
                return $this->handleNotFoundResponse($action);
            }
        } else {
            return $this->handleErrorResponse($action);
        }
    }

    /**
     * Handle a response for a resource not found scenario.
     * @param Actions $action A string that refers to the action method.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleNotFoundResponse(Actions $action): Response|ResponseFactory
    {
        $message = [
            'title'       => __('translations.not_found_message.title'),
            'description' => __('translations.not_found_message.description'),
        ];

        return response($message, 200);
    }

    /**
     * Handle a successful response for the API request.
     * @param LengthAwarePaginator|Collection|array|null $records The records to be included in the response.
     * @param Actions $action A string that refers to the action method.
     * @param array|null $apiDataModel An array representing the data model information.
     * @param array|null $apiColumnModel An array representing the column model information.
     * @param array|null $apiFilterModel An array representing the filter model information.
     * @param array|null $apiStatisticalIndicators An array representing the reports model information.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleSuccessResponse(
        LengthAwarePaginator|Collection|array|null $records = null,
        Actions $action,
        array $apiDataModel = null,
        array $apiColumnModel = null,
        array $apiFilterModel = null,
        array $apiStatisticalIndicators = null
    ): Response|ResponseFactory {
        $message = [
            'title'       => __('translations.ok_message.title'),
            'description' => __('translations.ok_message.description'),
            'results'     => $records,
        ];

        if (is_array($apiDataModel) && count($apiDataModel)) {
            $message['models'] = $apiDataModel;
        }

        if (is_array($apiColumnModel) && count($apiColumnModel)) {
            $message['columns'] = $apiColumnModel;
        }

        if (is_array($apiFilterModel) && count($apiFilterModel)) {
            $message['filters'] = $apiFilterModel;
        }

        if (is_array($apiStatisticalIndicators) && count($apiStatisticalIndicators)) {
            $message['reports'] = $apiStatisticalIndicators;
        }

        return response($message, $action->name === 'create' ? 201 : 200);
    }

    /**
     * Handle an error response for the API request.
     * @param Actions $action A string that refers to the action method.
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleErrorResponse(Actions $action): Response|ResponseFactory
    {
        if ($action->name === 'not_allowed') {
            $message = [
                'title'       => __('translations.not_allowed_message.title'),
                'description' => __('translations.not_allowed_message.description'),
            ];

            return response($message, 405);
        } elseif ($action->name === 'not_found_record') {
            $message = [
                'title'       => __('translations.not_found_record_message.title'),
                'description' => __('translations.not_found_record_message.description'),
            ];

            return response($message, 200);
        } else {
            $message = [
                'title'       => __('translations.error_message.title'),
                'description' => __('translations.error_message.description'),
            ];

            return response($message, 500);
        }
    }
}
