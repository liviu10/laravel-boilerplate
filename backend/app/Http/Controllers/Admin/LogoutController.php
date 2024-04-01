<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    protected User $modelName;

    public function __construct()
    {
        $this->modelName = new User();
    }

    public function logout(UserRequest $request): Response|ResponseFactory
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();

            return response([
                'title' => __('translation.success_message.title'),
                'description' => __('translation.success_message.description'),
            ], 200);
        }
        else{
            return response([
                'title' => __('translation.unauthorized_message.title'),
                'description' => __('translation.unauthorized_message.description'),
            ], 401);
        }
    }
}
