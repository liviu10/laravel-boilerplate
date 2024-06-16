<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
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
            'title' => __('Settings'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
            'shortcuts' => [
                $this->handleShortcuts()
            ]
        ];

        return view('pages.admin.settings.index', compact('data'));
    }

    private function handleShortcuts(): array
    {
        return [
            [
                'id' => 1,
                'title' => __('Users'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('users.index')
            ],
            [
                'id' => 2,
                'title' => __('Application settings'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('application.index')
            ],
            [
                'id' => 3,
                'title' => __('Optimize'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('settings.optimize'),
                'button_label' => __('Run'),
                'button_icon' => 'fa-solid fa-terminal'
            ],
        ];
    }

    public function optimize(): View|Application|Factory
    {
        Artisan::call('optimize:clear');

        return $this->index();
    }
}
