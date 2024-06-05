<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\ContentType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContentTypeController extends Controller
{
    protected $contentType;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contentType = new ContentType();
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
            'title' => __('Content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'types.index',
                'create' => 'types.create',
                'show' => 'types.show',
                'edit' => 'types.edit',
                // 'destroy' => 'types.destroy',
                // 'restore' => 'types.restore',
            ],
            'filter_form' => [
                'action' => 'types.index',
                'inputs' => $this->handleFormInputs(),
            ],
            'results' => $this->contentType->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.content.types.index', compact('data'));
    }

    private function handleFormInputs(): array
    {
        return [
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
        ];
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
            'action' => 'types.store',
            'results' => $this->handleFormInputs(),
        ];

        return view('pages.admin.management.content.types.create', compact('data'));
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
        $result = $this->contentType->createRecord($payload);

        return redirect()->route('types.index')->with('success', $result);
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
            'title' => __('Edit a content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'types.update',
            'rowId' => $id,
            'results' => $this->handleFormInputs(),
        ];

        $selectedRecord = $this->contentType->fetchSingleRecord($id);
        foreach ($data['results'] as &$result) {
            foreach ($selectedRecord->toArray()[0] as $recordKey => $recordValue) {
                if ($result['key'] === $recordKey) {
                    $result['value'] = $recordValue;
                    break;
                }
            }
        }

        return view('pages.admin.management.content.types.edit', compact('data'));
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
        $selectedRecord = $this->contentType->fetchSingleRecord($id);
        $result = $this->contentType->updateRecord($payload, $id);

        return redirect()->route('types.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
