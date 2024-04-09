<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utilities\HandleApi;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected User $modelName;
    protected HandleApi $handleApi;

    public function __construct()
    {
        $this->modelName = new User();
        $this->handleApi = new HandleApi();
    }

    public function register(UserRequest $request): Response|ResponseFactory
    {
        $validatedData = $request->validated();
        $payload = [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'nickname' => $validatedData['nickname'],
            'email' => $validatedData['email'],
            'phone' => null,
            'password' => Hash::make($validatedData['password']),
        ];
        $payload['full_name'] = $payload['first_name'] . '' . $payload['last_name'];
        $payload['profile_image'] = $this->modelName->getProfileImageUrl($payload);

        $query = $this->modelName->createRecord($payload);

        return $this->handleApi->handleApiResponse(
            $query,
            User::class
        );
    }
}
