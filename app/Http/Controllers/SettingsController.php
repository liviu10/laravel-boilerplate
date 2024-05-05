<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $data = [
            'resources' => [
                'content' => $this->handleUserResources(),
            ]
        ];
        return view('pages.admin-settings', compact('data'));
    }

    private function handleUserResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Users',
                'url' => '/admin/settings/users'
            ],
        ];
    }
}
