<?php

namespace App\Http\Controllers;

use App\Models\ContactSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContactSubjectController extends Controller
{
    protected $contactSubject;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contactSubject = new ContactSubject();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'is_active';
        }, ARRAY_FILTER_USE_BOTH);
        unset($searchTerms['_token']);

        $data = [
            'title' => __('Contact subjects'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.
            '),
            'results' => [
                'columns' => [
                    __('ID'),
                    __('Value'),
                    __('Label'),
                    __('Is active'),
                    __('Actions')
                ],
                'rows' => $this->contactSubject->fetchAllRecords($searchTerms),
                'forms' => [
                    'create_form' => $this->handleForm('subjects.store'),
                    'filter_form' => $this->handleForm('subjects.index'),
                    'update_form' => $this->handleForm('subjects.update'),
                    'delete_form' => $this->handleForm('subjects.destroy'),
                ],
                'options' => [
                    'canAdd' => true,
                    'canFilter' => true,
                    'hasActions' => true,
                    'canShow' => true,
                    'canUpdate' => true,
                    'canDelete' => true,
                    'canRestore' => false,
                    'hasPagination' => false,
                ],
            ],
        ];

        return view('pages.admin-contact-subjects', compact('data'));
    }

    private function handleForm(string $action): array
    {
        return [
            'action' => $action,
            'inputs' => [
                [
                    'id' => 1,
                    'key' => 'label',
                    'placeholder' => __('Subject'),
                    'type' => 'text',
                    'value' => ''
                ],
                [
                    'id' => 2,
                    'key' => 'is_active',
                    'placeholder' => __('Is active?'),
                    'type' => 'select',
                    'value' => '',
                    'options' => [
                        [
                            'id' => 1,
                            'value' => 0,
                            'label' => __('No'),
                        ],
                        [
                            'id' => 2,
                            'value' => 1,
                            'label' => __('Yes'),
                        ]
                    ],
                ],
            ]
        ];
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
    public function store(Request $request)
    {
        $successMessage = __('The record was successfully saved');
        $errorMessage = __('The record was not saved in the database');

        $validateRequest = [
            'label' => 'required|string',
            'is_active' => 'required|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['value'] = strtolower(str_replace(' ', '-', $payload['label']));
        $payload['is_active'] = isset($payload['is_active']) ? $payload['is_active'] : false;
        $payload['user_id'] = Auth::user()->id;
        $result = $this->contactSubject->createRecord($payload);

        return redirect()->route('subjects.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        abort(405, __('The action is not allowed.'));
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
        $successMessage = __('The record was successfully updated');
        $errorMessage = __('The record was not update in the database');

        $validateRequest = [
            'label' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['value'] = strtolower(str_replace(' ', '-', $payload['label']));
        $payload['is_active'] = isset($payload['is_active']) ? $payload['is_active'] : false;
        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->contactSubject->fetchSingleRecord($id);
        $result = $this->contactSubject->updateRecord($payload, $id);

        return redirect()->route('subjects.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
