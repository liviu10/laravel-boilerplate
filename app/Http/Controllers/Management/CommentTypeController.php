<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\CommentType;
use App\Utilities\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CommentTypeController extends Controller
{
    protected $commentType;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->commentType = new CommentType();
        $this->formBuilder = new FormBuilder();
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
            'title' => __('Comment type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'commentTypes.index',
                'create' => 'commentTypes.create',
                'show' => 'commentTypes.show',
                'edit' => 'commentTypes.edit',
                // 'destroy' => 'types.destroy',
                // 'restore' => 'types.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->commentType->getInputs()
            ),
            'results' => $this->commentType->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.content.comments.types.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => __('Create a comment type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'commentTypes.store',
            'results' => $this->formBuilder->handleFormBuilder(
                $this->commentType->getInputs()
            ),
        ];

        return view('pages.admin.management.content.comments.types.create', compact('data'));
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
        $result = $this->commentType->createRecord($payload);

        return redirect()->route('commentTypes.index')->with('success', $result);
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
            'title' => __('Edit a comment type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'commentTypes.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->commentType->getInputs()
            ),
        ];

        $selectedRecord = $this->commentType->fetchSingleRecord($id);
        $data['results'] = $this->formBuilder->handlePopulateInput($selectedRecord, $data['results']);

        return view('pages.admin.management.content.comments.types.edit', compact('data'));
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
        $result = $this->commentType->updateRecord($payload, $id);

        return redirect()->route('commentTypes.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
