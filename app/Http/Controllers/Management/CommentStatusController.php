<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\CommentStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CommentStatusController extends Controller
{
    protected $commentStatus;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->commentStatus = new CommentStatus();
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

        $data = [
            'title' => __('Comment statuses'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->commentStatus->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.contents.comments.statuses.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => __('Create a comment status'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => [
                [
                    'id' => 1,
                    'key' => 'label',
                    'placeholder' => __('Type'),
                    'type' => 'text',
                    'value' => ''
                ],
                [
                    'id' => 2,
                    'key' => 'is_active',
                    'placeholder' => __('Is active?'),
                    'type' => 'select',
                    'value' => null,
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
            ],
        ];

        return view('pages.admin.management.contents.comments.statuses.create', compact('data'));
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
        $result = $this->commentStatus->createRecord($payload);

        return redirect()->route('pages.admin.management.contents.comments.statuses.index')->with('success', $result ? $successMessage : $errorMessage);
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
    public function edit(string $id)
    {
        $data = [
            'title' => __('Edit a comment status'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => [
                [
                    'id' => 1,
                    'key' => 'label',
                    'placeholder' => __('Type'),
                    'type' => 'text',
                    'value' => ''
                ],
                [
                    'id' => 2,
                    'key' => 'is_active',
                    'placeholder' => __('Is active?'),
                    'type' => 'select',
                    'value' => null,
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
            ],
        ];

        return view('pages.admin.management.contents.comments.statuses.edit', compact('data'));
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
        $selectedRecord = $this->commentStatus->fetchSingleRecord($id);
        $result = $this->commentStatus->updateRecord($payload, $id);

        return redirect()->route('pages.admin.management.contents.comments.statuses.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
