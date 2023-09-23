<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::user() && Auth::user() === null) {
        //     $message = [
        //         'title'       => __('translations.unauthorized_message.title'),
        //         'description' => __('translations.unauthorized_message.description'),
        //     ];

        //     return response($message, 401);
        // } else {
            return $next($request);
        // }
    }
}
