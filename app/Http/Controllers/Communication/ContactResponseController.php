<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\ContactResponse;
use App\Mail\RespondToContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContactResponseController extends Controller
{
    protected $contactResponse;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contactResponse = new ContactResponse();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a contact response'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => [
                [
                    'id' => 1,
                    'key' => 'contact_message_id',
                    'placeholder' => __('Contact message'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [], // TODO: Bring the contact messages here
                ],
                [
                    'id' => 2,
                    'key' => 'message',
                    'placeholder' => __('Response'),
                    'type' => 'textarea',
                    'value' => '',
                ],
            ],
        ];

        return view('pages.admin.communication.contact.responses.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $successMessage = __('The record was successfully updated');
        $errorMessage = __('The record was not update in the database');

        $validateRequest = [
            'contact_message_id' => 'required|integer',
            'message' => 'required|string',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->contactResponse->saveRecord($payload);

        if ($result instanceof ContactResponse) {
            $contactMessage = $this->contactResponse->fetchSingleRecord($payload['contact_message_id'])->toArray();
            Mail::to($contactMessage['email'])->send(new RespondToContactMessage($contactMessage));
        }

        return redirect()->route('pages.admin.communication.contact.responses.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Display the specified resource.
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
