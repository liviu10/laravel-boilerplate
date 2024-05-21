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
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'privacy_policy';
        }, ARRAY_FILTER_USE_BOTH);
        unset($searchTerms['_token']);

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
            'results' => [
                'columns' => [
                    __('ID'),
                    __('Contact subject'),
                    __('Full name'),
                    __('Email'),
                    __('Phone'),
                    __('Privacy policy'),
                    __('Actions')
                ],
                'rows' => $this->contactMessage->fetchAllRecords($searchTerms),
                'forms' => [
                    'create_form' => $this->handleForm('messages.store'),
                    'filter_form' => $this->handleForm('messages.index'),
                    'update_form' => $this->handleForm('messages.update'),
                    'delete_form' => $this->handleForm('messages.destroy'),
                ],
                'options' => [
                    'canAdd' => true,
                    'canFilter' => true,
                    'hasActions' => true,
                    'canShow' => true,
                    'canUpdate' => true,
                    'canDelete' => true,
                    'canRestore' => true,
                    'hasPagination' => true,
                ],
            ],
        ];

        return view('pages.admin-contact-message', compact('data'));
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
