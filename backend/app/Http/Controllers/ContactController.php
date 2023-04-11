<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactSubject;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $modelContact;
    protected $modelContactSubject;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelContact = new Contact();
        $this->modelContactSubject = new ContactSubject();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $errorMessage = __('contact.error_message_fetch');
        $displayAllRecords = [
            'contact' => $this->modelContact->fetchAllContactMessage() ? $this->modelContact->fetchAllContactMessage() : $errorMessage,
            'contact_subjects' => $this->modelContactSubject->fetchAllContactSubjects()
        ];
        return view('contact', compact('displayAllRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $successMessage = __('contact.success_message');
        $errorMessage = __('contact.error_message_update');

        $validateRequest = [
            'full_name'          => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'email'              => 'required|string|min:3|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'phone'              => 'required|string|min:10|max:255|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/',
            'contact_subject_id' => 'required',
            'message'            => 'required|string|min:10',
            // 'privacy_policy'     => 'boolean',
        ];
        $saveRecords = array_filter($request->all());
        $request->validate($validateRequest);

        $result = $this->modelContact->saveContactMessage($saveRecords);

        return redirect()->route('contact.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Filter the specified contact message.
     * @param Request $request The HTTP request object containing the filter information.
     * @return RedirectResponse The HTTP redirect response after the filter is complete.
     */
    public function filter(Request $request)
    {
        dd($request->all());
        return redirect()->route('contact.index');
    }
}
