<?php

namespace App\Utilities;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

enum Actions
{
    case get;
    case create;
    case update;
    case delete;
    case not_allowed;
    case not_found_record;
    case forbidden;
}

class ApiResponse
{
    /**
     * Generate an API response based on the provided records, fields, and model name.
     * @param LengthAwarePaginator|Collection|array|null $records The records to be included in the response.
     * @param Actions $action A string that refers to the action method.
     * @return Response|ResponseFactory The generated API response or response factory.
     */
    public function generateApiResponse(
        LengthAwarePaginator|Collection|array|null $records = null,
        Actions $action,
    ): Response|ResponseFactory {
        if ($records instanceof LengthAwarePaginator || $records instanceof Collection) {
            if ($records->isEmpty()) {
                return $this->handleNotFoundResponse($action);
            } else {
                return $this->handleSuccessResponse($records, $action);
            }
        } elseif (is_array($records)) {
            if (count($records)) {
                return $this->handleSuccessResponse($records, $action);
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
     * @return Response|ResponseFactory The generated response or response factory.
     */
    private function handleSuccessResponse(
        LengthAwarePaginator|Collection|array|null $records = null,
        Actions $action,
    ): Response|ResponseFactory {
        $message = [
            'title'       => __('translations.ok_message.title'),
            'description' => __('translations.ok_message.description'),
            'results'     => $records,
        ];

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
        } elseif ($action->name === 'forbidden') {
            $message = [
                'title'       => __('translations.forbidden_message.title'),
                'description' => __('translations.forbidden_message.description'),
            ];

            return response($message, 403);
        } else {
            $message = [
                'title'       => __('translations.error_message.title'),
                'description' => __('translations.error_message.description'),
            ];

            return response($message, 500);
        }
    }
}
