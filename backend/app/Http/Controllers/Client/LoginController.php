<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected User $modelName;

    public function __construct()
    {
        $this->modelName = new User();
    }

    public function login(UserRequest $request): Response|ResponseFactory
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $currentAuthUser = Auth::user();
            $token = $currentAuthUser
                ->createToken(config('app.token_name'))
                ->plainTextToken;

            return response([
                'title' => __('translation.success_message.title'),
                'description' => __('translation.success_message.description'),
                'token' => $token,
                'results' => $currentAuthUser,
            ], 200);
        } else {
            return response([
                'title' => __('translation.unauthorized_message.title'),
                'description' => __('translation.unauthorized_message.description'),
            ], 401);
        }
    }
}
