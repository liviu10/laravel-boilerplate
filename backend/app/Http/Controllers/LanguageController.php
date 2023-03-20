<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

/**
 * Controller for managing language selection by users.
 */
class LanguageController extends Controller
{
    /**
     * Sets the language for the application based on the user's selection, and redirects the user back to the previous page.
     * @param string $language The language code to set.
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
     */
    public function switchLang($language)
    {
        if (array_key_exists($language, Config::get('languages')))
        {
            Session::put('applicationLanguage', $language);
        }
        return Redirect::back();
    }
}
