<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $modelContact;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelContact = new Contact();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $errorMessage = __('contact.error_message_fetch');
        $displayAllRecords = $this->modelContact->fetchAllContactMessage() ? $this->modelContact->fetchAllContactMessage() : $errorMessage;
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
            'full_name'      => 'required|string|min:3|max:255',
            'email'          => 'required|string|min:3|max:255',
            'phone'          => 'required|string|min:3|max:255',
            'message'        => 'required|string|min:10',
            // 'privacy_policy' => 'boolean',
        ];
        $saveRecords = array_filter($request->all());
        $request->validate($validateRequest);

        $result = $this->modelContact->saveContactMessage($saveRecords);

        return redirect()->route('contact.index')->with('success', $result ? $successMessage : $errorMessage);
    }
}
