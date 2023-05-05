<?php

namespace App\Http\Controllers;

use App\Mail\ContactResponseMail;
use App\Models\Contact;
use App\Models\ContactResponse;
use App\Models\ContactSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    protected $modelContact;
    protected $modelContactResponse;
    protected $modelContactSubject;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelContact = new Contact();
        $this->modelContactResponse = new ContactResponse();
        $this->modelContactSubject = new ContactSubject();
    }

    /**
     * Show the the list of all users and the user role types.
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $errorMessage = __('admin.general.error_message_fetch');

        $searchTerms = array_filter($request->except('page'));
        $results = [
            'contact' => $this->modelContact->fetchAllContactMessage($searchTerms),
            'contact_subjects' => $this->modelContactSubject->fetchAllContactSubjects()
        ];

        $searchMessage = __('admin.general.search_results_label') . ' (';
        $keyNames = [
            'contact_subject_id' => 'contact_subject'
        ];
        foreach ($searchTerms as $key => $value) {
            if (array_key_exists($key, $keyNames)) {
                $key = $keyNames[$key];
                if ($key === 'contact_subject') {
                    $value = $results['contact_subjects']->firstWhere('id', $value)?->toArray()['title'];
                }
            }
            if ($key === 'privacy_policy')
            {
                if ($value === '1')
                {
                    $value = __('admin.general.yes_label');
                }
                else
                {
                    $value = __('admin.general.no_label');
                }
            }
            $searchMessage .= "$key: $value, ";
        }
        $searchMessage = rtrim($searchMessage, ', ') . ')';
        $displayAllRecords = $results ?: $errorMessage;

        return view('contact', compact('displayAllRecords', 'searchTerms', 'searchMessage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $successMessage = __('admin.general.success_message');
        $errorMessage = __('admin.general.error_message_update');

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
     * Delete a contact message.
     * @param string $id The ID of the contact message to delete.
     * @return \Illuminate\Http\RedirectResponse A redirect to the index page with a success or error message.
     */
    public function destroy(string $id)
    {
        $successMessage = __('admin.general.success_message');
        $errorMessage = __('admin.general.error_message_delete');

        $result = $this->modelContact->deleteContactMessage($id);

        return redirect()->route('contact.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function replyToMessage(Request $request)
    {
        $successMessage = __('admin.general.success_message_reply');
        $errorMessage = __('admin.general.error_message_reply');

        $validateRequest = [
            'message' => 'required|string|min:10',
        ];
        $saveRecords = array_filter($request->all());
        $request->validate($validateRequest);

        $result = $this->modelContactResponse->saveContactResponse($saveRecords);

        if ($result)
        {
            $contactMessageDetail = $this->modelContact->fetchSingleContactMessage($request->get('id'));
            $contactMailDetails = [
                'email_from' => config('app.email'),
                'email_to' => $contactMessageDetail->toArray()[0]['email'],
                'subject_message' => $contactMessageDetail->toArray()[0]['contact_subject']['title'],
                'full_name' => $contactMessageDetail->toArray()[0]['full_name'],
                'contact_message' => $contactMessageDetail->toArray()[0]['message'],
                'message_date' => $contactMessageDetail->toArray()[0]['created_at'],
                'reply_message' => $request->get('message')
            ];

            Mail::to($contactMailDetails['email_to'])->send(new ContactResponseMail($contactMailDetails));

            return redirect()->route('contact.index')->with('success', $result ? $successMessage : $errorMessage);
        }
    }
}
