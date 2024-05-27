<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;

class CommunicationController extends Controller
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
        Log::info('Index method in CommunicationController called');

        $data = [
            'title' => __('Communication'),
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

        return view('pages.admin.communication.index', compact('data'));
    }

    private function handleShortcuts(): array
    {
        return [
            [
                'id' => 1,
                'title' => __('Contact subjects'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('subjects.index')
            ],
            [
                'id' => 2,
                'title' => __('Contact messages'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('messages.index')
            ],
            [
                'id' => 3,
                'title' => __('Newsletter campaigns'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('campaigns.index')
            ],
            [
                'id' => 4,
                'title' => __('Newsletter subscribers'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('subscribers.index')
            ],
            [
                'id' => 5,
                'title' => __('Reviews'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => route('reviews.index')
            ],
        ];
    }
}
