<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that sets the language for the application based on the user's session data or the default language specified in the configuration file.
 */
class Language
{
    /**
     * Sets the language for the application based on the user's session data or the default language specified in the configuration file.
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Closure $next The closure representing the next middleware in the pipeline.
     * @return \Illuminate\Http\Response The response object returned by the next middleware in the pipeline.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session()->has('applicationLanguage') AND array_key_exists(Session()->get('applicationLanguage'), config('languages')))
        {
            App::setLocale(Session()->get('applicationLanguage'));
        }
        else
        {
            App::setLocale(config('app.fallback_locale'));
        }
        return $next($request);
    }
}
