<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    protected $newsletterSubscriber;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->newsletterSubscriber = new NewsletterSubscriber();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $data = [
            'title' => __('Newsletter subscribers'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
            'results' => $this->newsletterSubscriber->fetchAllRecords(),
        ];

        return view('pages.admin-newsletter-subscriber', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
