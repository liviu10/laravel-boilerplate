<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactSubject;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $contactMessage;
    protected $contactSubject;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contactMessage = new ContactMessage();
        $this->contactSubject = new ContactSubject();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $data = [
            'title' => __('Contact messages'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
            'results' => $this->contactMessage->fetchAllRecords(),
            'contact_subjects' => [
                'title' => __('Contact subjects'),
                'results' => $this->contactSubject->fetchAllRecords(),
            ],
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
            'results' => $this->contactMessage->fetchSingleRecord($id),
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
