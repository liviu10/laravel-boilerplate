<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\ContentVisibility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContentVisibilityController extends Controller
{
    protected $contentVisibility;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contentVisibility = new ContentVisibility();
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
            'title' => __('Content visibility'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->contentVisibility->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.content.visibilities.index', compact('data'));
    }

    private function handleFormInputs(): array
    {
        return [
            [
                'id' => 1,
                'key' => 'label',
                'placeholder' => __('Visibility'),
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
        ];
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content visibility'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'visibilities.store',
            'results' => $this->handleFormInputs(),
        ];

        return view('pages.admin.management.content.visibilities.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'label' => 'required|string',
            'is_active' => 'sometimes|nullable|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['value'] = strtolower(str_replace(' ', '-', $payload['label']));
        $payload['is_active'] = isset($payload['is_active']) ? $payload['is_active'] : false;
        $payload['user_id'] = Auth::user()->id;
        $result = $this->contentVisibility->createRecord($payload);

        return redirect()->route('visibilities.index')->with('success', $result);
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
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Edit a content visibility'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'visibilities.update',
            'results' => $this->handleFormInputs(),
        ];

        return view('pages.admin.management.content.visibilities.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'label' => 'sometimes|string',
            'is_active' => 'sometimes|nullable|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['value'] = strtolower(str_replace(' ', '-', $payload['label']));
        $payload['is_active'] = isset($payload['is_active']) ? $payload['is_active'] : false;
        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->contentVisibility->fetchSingleRecord($id);
        $result = $this->contentVisibility->updateRecord($payload, $id);

        return redirect()->route('visibilities.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
