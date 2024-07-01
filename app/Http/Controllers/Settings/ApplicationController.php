<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Application as ApplicationSettings;
use App\Utilities\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $application;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->application = new ApplicationSettings();
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
            'title' => __('Application settings'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'application.index',
                'create' => 'application.create',
                'show' => 'application.show',
                'edit' => 'application.edit',
                // 'destroy' => 'application.destroy',
                // 'restore' => 'application.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->application->getInputs()
            ),
            'results' => $this->application->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.settings.application.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => __('Create an application setting'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'application.store',
            'results' => $this->formBuilder->handleFormBuilder(
                $this->application->getInputs()
            ),
        ];

        return view('pages.admin.settings.application.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'value' => 'required|string',
            'label' => 'required|string',
            'description' => 'sometimes|string',
            'is_active' => 'sometimes|nullable|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['is_active'] = isset($payload['is_active']) ? $payload['is_active'] : false;
        $payload['user_id'] = Auth::user()->id;
        $result = $this->application->createRecord($payload);

        return redirect()->route('application.index')->with('success', $result);
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
            'title' => __('Edit an application setting'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'application.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->application->getInputs()
            ),
        ];

        $selectedRecord = $this->application->fetchSingleRecord($id);
        $data['results'] = $this->formBuilder->handlePopulateInput($selectedRecord, $data['results']);

        return view('pages.admin.settings.application.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'value' => 'sometimes|string',
            'label' => 'sometimes|string',
            'description' => 'sometimes|string',
            'is_active' => 'sometimes|nullable|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['is_active'] = isset($payload['is_active']) ? $payload['is_active'] : false;
        $payload['user_id'] = Auth::user()->id;
        $result = $this->application->updateRecord($payload, $id);

        return redirect()->route('application.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
