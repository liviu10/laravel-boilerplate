<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
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
        return view('pages.admin-newsletter-subscriber');
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
