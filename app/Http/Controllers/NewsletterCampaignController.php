<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsletterCampaignController extends Controller
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
        return view('pages.admin-newsletter-campaign');
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('pages.admin-newsletter-campaign-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        return view('pages.admin-newsletter-campaign-show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $id
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        return view('pages.admin-newsletter-campaign-edit');
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
    public function destroy(string $id)
    {
        //
    }
}
