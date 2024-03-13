<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ApiInterface;
use App\Interfaces\UserInterface;
use App\Traits\GravatarProfileImageUrl;
use App\Models\User;
use App\Utilities\ApiResponse;
use App\Utilities\Actions;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class UserController extends Controller implements ApiInterface, UserInterface
{
    use GravatarProfileImageUrl;

    protected $modelName;
    protected $apiResponse;
    protected $defaultPassword;

    public function __construct()
    {
        $this->modelName = new User();
        $this->apiResponse = new ApiResponse();
        $this->defaultPassword = '!z1{7}2Q%94"';
    }

    /**
     * Handle the index operation.
     *
     * @param array $search An array containing search parameters.
     * @param string|null $type Optional type parameter.
     * @return Response|ResponseFactory
     */
    public function index(array $search = [], string|null $type = null): Response|ResponseFactory
    {
        $apiDisplayAllRecords = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchAllRecords($search, $type),
            Actions::get
        );

        return $apiDisplayAllRecords;
    }

    /**
     * Handle the store operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing request data.
     * @return Response|ResponseFactory
     */
    public function store(Request $request): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(UserRequest::rules());

        $apiInsertRecord = [
            'full_name' => $validatedRequest['first_name'] . ' ' . $validatedRequest['last_name'],
            'first_name' => $validatedRequest['first_name'],
            'last_name' => $validatedRequest['last_name'],
            'email' => $validatedRequest['email'],
            'password' => bcrypt($this->defaultPassword),
            'profile_image' => array_key_exists('profile_image', $request->all())
                ? $validatedRequest['profile_image']
                : $this->getProfileImageUrl(
                    $validatedRequest['email'],
                    $validatedRequest['first_name'],
                    $validatedRequest['last_name']
                ),
        ];

        $createdRecord = $this->modelName->createRecord($apiInsertRecord);
        $apiCreatedRecord = $this->apiResponse->generateApiResponse(
            $createdRecord->toArray(),
            Actions::create
        );

        return $apiCreatedRecord;
    }

    /**
     * Handle the show operation.
     *
     * @param string $id The identifier for the resource.
     * @param string|null $type Optional type parameter.
     * @return Response|ResponseFactory
     */
    public function show(string $id, string|null $type = null): Response|ResponseFactory
    {
        $apiDisplaySingleRecord = $this->apiResponse->generateApiResponse(
            $this->modelName->fetchSingleRecord($id, 'relation'),
            Actions::get
        );

        return $apiDisplaySingleRecord;
    }

    /**
     * Handle the update operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing update data.
     * @param string $id The identifier for the resource to be updated.
     * @return Response|ResponseFactory
     */
    public function update(Request $request, string $id): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(UserRequest::rules());

        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
            $apiUpdateRecord = [
                'first_name' => array_key_exists('first_name', $request->all())
                    ? $validatedRequest['first_name']
                    : $apiDisplaySingleRecord->toArray()[0]['first_name'],
                'last_name' => array_key_exists('last_name', $request->all())
                    ? $validatedRequest['last_name']
                    : $apiDisplaySingleRecord->toArray()[0]['last_name'],
            ];

            $apiUpdateRecord['full_name'] = $apiUpdateRecord['first_name'] . ' ' . $apiUpdateRecord['last_name'];

            $updatedRecord = $this->modelName->updateRecord($apiUpdateRecord, $id);
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse(
                $updatedRecord->toArray(),
                Actions::update
            );
        } else {
            $apiUpdatedRecord = $this->apiResponse->generateApiResponse(
                null,
                Actions::not_found_record
            );
        }

        return $apiUpdatedRecord;
    }

    /**
     * Handle the destroy operation.
     *
     * @param string $id The identifier for the resource to be destroyed.
     * @return Response|ResponseFactory
     */
    public function destroy(string $id): Response|ResponseFactory
    {
        $apiDisplaySingleRecord = $this->modelName->fetchSingleRecord($id);
        if ($apiDisplaySingleRecord && $apiDisplaySingleRecord->isNotEmpty()) {
            $this->modelName->deleteRecord($id);
            $apiDeleteRecord = $this->apiResponse->generateApiResponse(
                $apiDisplaySingleRecord,
                Actions::delete
            );
        } else {
            $apiDeleteRecord = $this->apiResponse->generateApiResponse(
                null,
                Actions::not_found_record
            );
        }

        return $apiDeleteRecord;
    }

    /**
     * Handle the register operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing request data.
     * @return Response|ResponseFactory
     */
    public function register(Request $request): Response|ResponseFactory
    {
        //
    }

    /**
     * Handle the login operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing login data.
     * @return Response|ResponseFactory
     */
    public function login(Request $request): Response|ResponseFactory
    {
        //
    }

    /**
     * Handle the update user profile operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing update data.
     * @param string $id The identifier for the resource.
     * @return Response|ResponseFactory
     */
    public function userProfile(Request $request, string $id): Response|ResponseFactory
    {
        //
    }
}
