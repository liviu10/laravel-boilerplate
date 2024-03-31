<?php

namespace App\Utilities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;

class HandleApi
{
    protected string|null $routeMethod;
    protected array $response;
    protected int|null $statusCode;

    public function __construct()
    {
        $this->routeMethod = Route::current()->methods[0];
        $this->response = [];
        $this->statusCode = null;
    }

    /**
     * Handle the response.
     *
     * @param Collection|Model|Exception|bool $query
     * @param null $modelInstance
     * @return Response|ResponseFactory
     */
    public function handleApiResponse(
        Collection|Model|Exception|bool $query,
        $modelInstance = null
    ): Response|ResponseFactory
    {
        switch ($this->routeMethod) {
            case 'GET':
                if ($query instanceof Collection) {
                    if ($query->isNotEmpty()) {
                        return $this->handleApiSuccessResponse($query);
                    } else {
                        return $this->handleApiNotFoundResponse();
                    }
                }
                return $this->handleApiErrorResponse();
            case 'POST':
            case 'PUT':
            case 'DELETE':
                if ($modelInstance) {
                    return $this->handleApiSuccessResponse($query);
                } else {
                    return $this->handleApiNotFoundResponse();
                }
            default:
                return $this->handleApiErrorResponse();
        }
    }

    /**
     * Handle payload validation for store and update operation.
     *
     * @param $validationClass
     * @param array $fillable
     * @param Collection|Exception|null $record
     * @return array
     */
    public function handlePayload($validationClass, array $fillable, Collection|Exception|null $record = null): array
    {
        $request = app($validationClass);
        $validatedData = $request->validated();

        $payload = [];
        foreach ($fillable as $field) {
            $payload[$field] = array_key_exists($field, $validatedData)
                ? $validatedData[$field]
                : null;
        }

        if ($record) {
            if ($record instanceof Collection && $record->isNotEmpty()) {
                foreach ($record->toArray()[0] as $key => $value) {
                    if (array_key_exists($key, $payload) && $payload[$key] === null) {
                        $payload[$key] = $value;
                    }
                }
            }
        }

        return $payload;
    }

    /**
     * Handle the success response.
     *
     * @param Collection|Model|bool $query
     * @return Response|ResponseFactory
     */
    private function handleApiSuccessResponse(Collection|Model|bool $query): Response|ResponseFactory
    {
        $this->response['title'] = __('translation.success_message.title');
        $this->response['description'] = __('translation.success_message.description');
        $this->response['results'] =
            $this->routeMethod === 'POST' || $this->routeMethod === 'PUT'
                ? $query->toArray()
                : $query;
        $this->statusCode = $this->routeMethod === 'POST'
            ? 201
            : 200;

        return response($this->response, $this->statusCode);
    }

    /**
     * Handle the not found response.
     *
     * @return Response|ResponseFactory
     */
    private function handleApiNotFoundResponse(): Response|ResponseFactory
    {
        $this->response['title'] = __('translation.not_found_message.title');
        $this->response['description'] = __('translation.not_found_message.description');
        $this->response['results'] = [];
        $this->statusCode = 200;

        return response($this->response, $this->statusCode);
    }

    /**
     * Handle the error response.
     *
     * @return Response|ResponseFactory
     */
    private function handleApiErrorResponse(): Response|ResponseFactory
    {
        $this->response['title'] = __('translation.error_message.title');
        $this->response['description'] = __('translation.error_message.description');
        $this->response['results'] = [];
        $this->statusCode = 500;

        return response($this->response, $this->statusCode);
    }
}
