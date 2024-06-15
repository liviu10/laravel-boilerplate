<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ContactResponse;
use App\Mail\RespondToContactMessage;
use App\Utilities\FormBuilder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $contactMessage;
    protected $contactResponse;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contactMessage = new ContactMessage();
        $this->contactResponse = new ContactResponse();
        $this->formBuilder = new FormBuilder();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'privacy_policy' || $key === 'terms_and_conditions' || $key === 'data_protection';
        }, ARRAY_FILTER_USE_BOTH);

        $data = [
            'title' => __('Contact messages'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'messages.index',
                // 'create' => 'messages.create',
                'show' => 'messages.show',
                // 'edit' => 'messages.edit',
                // 'destroy' => 'messages.destroy',
                // 'restore' => 'messages.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->contactMessage->getInputs()
            ),
            'results' => $this->contactMessage->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.communication.contact.messages.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Display the specified resource.
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Show a contact message'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'messages.messageResponse',
            'rowId' => $id,
            'form' => $this->formBuilder->handleFormBuilder(
                $this->contactResponse->getInputs()
            ),
            'results' => $this->contactMessage->fetchSingleRecord($id),
        ];

        $keyMap = [
            'from' => config('app.contact_email'),
            'to' => $data['results']->toArray()[0]['email'],
            'subject' => 'Response to contact subject'
        ];

        foreach ($data['form'] as &$result) {
            foreach ($result as &$item) {
                if (array_key_exists($item['key'], $keyMap)) {
                    $item['value'] = $keyMap[$item['key']];
                    $item['is_message_response'] = true;
                    $item['disabled'] = true;
                    $item['readonly'] = true;
                }
            }
        }

        return view('pages.admin.communication.contact.messages.show', compact('data'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function messageResponse(Request $request)
    {
        $validateRequest = [
            'contact_message_id' => 'required|integer',
            'message' => 'required|string',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->contactResponse->createRecord($payload);

        if ($result instanceof ContactResponse) {
            $contactMessage = $this->contactResponse->fetchSingleRecord($result->id)->toArray()[0];
            Mail::to($contactMessage['contact_message']['email'])->send(new RespondToContactMessage($contactMessage));
        }

        return redirect()->route('messages.index')->with('success', $result);
    }
}
