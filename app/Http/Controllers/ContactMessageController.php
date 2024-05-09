<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $contactMessages;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contactMessages = new ContactMessage();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $data = [
            'results' => $this->contactMessages->all()
        ];

        return view('pages.admin-contact-message', compact('data'));
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
     * @param string $id
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        $data = [
            'results' => $this->contactMessages->fetchSingleRecord($id),
        ];

        return view('pages.admin-contact-message-show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $id
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        return view('pages.admin-contact-message-edit');
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
