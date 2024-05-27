<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    protected $content;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->content = new Content();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'allow_comments' || $key === 'allow_share';
        }, ARRAY_FILTER_USE_BOTH);

        $data = [
            'title' => __('Content'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->content->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.content.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'content.store',
            'results' => [
                [
                    'id' => 1,
                    'key' => 'content_visibility_id',
                    'placeholder' => __('Visibility'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [], // TODO: bring the content visibilities as value and label
                ],
                [
                    'id' => 2,
                    'key' => 'title',
                    'placeholder' => __('Title'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 3,
                    'key' => 'content_type_id',
                    'placeholder' => __('Type'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [], // TODO: bring the content types as value and label
                ],
                [
                    'id' => 4,
                    'key' => 'description',
                    'placeholder' => __('Description'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 5,
                    'key' => 'content',
                    'placeholder' => __('Content'),
                    'type' => 'textarea',
                    'value' => '',
                ],
                [
                    'id' => 6,
                    'key' => 'allow_comments',
                    'placeholder' => __('Allow comments'),
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
                [
                    'id' => 7,
                    'key' => 'allow_share',
                    'placeholder' => __('Allow share'),
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

        return view('pages.admin.management.content.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'content_visibility_id' => 'sometimes|integer',
            'title' => 'sometimes|string|min:3|max:255',
            'content_type_id' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'content' => 'sometimes|string',
            'allow_comments' => 'sometimes|boolean',
            'allow_share' => 'sometimes|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['content_url'] = config('app.url') .
            ($payload['content_type_id'] === 2 ? '/blog' : '') .
            '/' . str_replace(' ', '-', strtolower($payload['title']));
        $payload['user_id'] = Auth::user()->id;
        $result = $this->content->createRecord($payload);

        return redirect()->route('contents.index')->with('success', $result);
    }

    /**
     * Display the specified resource.
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Show a newsletter subscriber'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->content->fetchSingleRecord($id),
        ];

        return view('pages.admin.management.content.create', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'content.update',
            'results' => [
                [
                    'id' => 1,
                    'key' => 'content_visibility_id',
                    'placeholder' => __('Visibility'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [], // TODO: bring the content visibilities as value and label
                ],
                [
                    'id' => 2,
                    'key' => 'title',
                    'placeholder' => __('Title'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 3,
                    'key' => 'content_type_id',
                    'placeholder' => __('Type'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [], // TODO: bring the content types as value and label
                ],
                [
                    'id' => 4,
                    'key' => 'description',
                    'placeholder' => __('Description'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 5,
                    'key' => 'content',
                    'placeholder' => __('Content'),
                    'type' => 'textarea',
                    'value' => '',
                ],
                [
                    'id' => 6,
                    'key' => 'allow_comments',
                    'placeholder' => __('Allow comments'),
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
                [
                    'id' => 7,
                    'key' => 'allow_share',
                    'placeholder' => __('Allow share'),
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

        return view('pages.admin.management.content.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'content_visibility_id' => 'required|integer',
            'title' => 'required|string|min:3|max:255',
            'content_type_id' => 'required|integer',
            'description' => 'sometimes|string',
            'content' => 'required|string',
            'allow_comments' => 'required|boolean',
            'allow_share' => 'required|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['content_url'] = config('app.url') .
            ($payload['content_type_id'] === 2 ? '/blog' : '') .
            '/' . str_replace(' ', '-', strtolower($payload['title']));
        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->content->fetchSingleRecord($id);
        $result = $this->content->createRecord($payload);

        return redirect()->route('contents.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
