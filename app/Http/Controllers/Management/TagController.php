<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Content;
use App\Utilities\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tag;
    protected $content;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->tag = new Tag();
        $this->content = new Content();
        $this->formBuilder = new FormBuilder();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all());

        $data = [
            'title' => __('Tags'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'tags.index',
                'create' => 'tags.create',
                'show' => 'tags.show',
                'edit' => 'tags.edit',
                // 'destroy' => 'tags.destroy',
                // 'restore' => 'tags.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->tag->getInputs()
            ),
            'results' => $this->tag->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.tags.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a tag'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'tags.store',
            'results' => $this->formBuilder->handleFormBuilder(
                $this->tag->getInputs()
            ),
        ];

        return view('pages.admin.management.tags.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'content_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'sometimes|string',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['slug'] = str_replace(' ', '-', strtolower($payload['name']));
        $payload['user_id'] = Auth::user()->id;
        $result = $this->tag->createRecord($payload);

        return redirect()->route('tags.index')->with('success', $result);
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
            'title' => __('Update a tag'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'tags.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->tag->getInputs()
            ),
        ];

        $selectedRecord = $this->tag->fetchSingleRecord($id);
        $data['results'] = $this->formBuilder->handlePopulateInput($selectedRecord, $data['results']);

        return view('pages.admin.management.tags.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'content_id' => 'sometimes|integer',
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['slug'] = str_replace(' ', '-', strtolower($payload['name']));
        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->tag->fetchSingleRecord($id);
        $result = $this->tag->updateRecord($payload, $id);

        return redirect()->route('tags.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
