<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

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
        $data = [
            'resources' => [
                'contact' => $this->handleContactResources(),
                'newsletter' => $this->handleNewsletterResources(),
                'reviews' => $this->handleReviewResources(),
            ]
        ];
        return view('pages.admin-communication', compact('data'));
    }

    private function handleContactResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Contact subjects',
                'url' => '/admin/communication/contact/subjects'
            ],
            [
                'id' => 2,
                'title' => 'Contact messages',
                'url' => '/admin/communication/contact/messages'
            ],
            [
                'id' => 3,
                'title' => 'Contact responses',
                'url' => '/admin/communication/contact/responses'
            ]
        ];
    }

    private function handleNewsletterResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Newsletter campaigns',
                'url' => '/admin/communication/newsletter/campaigns'
            ],
            [
                'id' => 2,
                'title' => 'Newsletter subscribers',
                'url' => '/admin/communication/newsletter/subscribers'
            ],
        ];
    }

    private function handleReviewResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Reviews',
                'url' => '/admin/communication/reviews'
            ],
        ];
    }
}
