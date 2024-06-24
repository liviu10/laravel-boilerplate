<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    protected $content;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->content = new Content();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function renderPage(string $contentSlug = 'guest'): View|Application|Factory
    {
        $content = $this->content->fetchGuestPage($contentSlug);

        if ($content instanceof Collection && $content->isNotEmpty()) {
            $data = $content->toArray()[0];

            return view('pages.render-page', compact('data'));
        } else {
            abort(404);
        }
    }
}
