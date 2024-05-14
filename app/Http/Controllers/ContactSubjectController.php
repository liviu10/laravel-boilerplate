<?php

namespace App\Http\Controllers;

use App\Models\ContactSubject;
use Illuminate\Http\Request;

class ContactSubjectController extends Controller
{
    protected $modelContactSubject;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelContactSubject = new ContactSubject();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        abort(405, __('The action is not allowed.'));
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
        dd($request);
        $successMessage = __('The record was successfully saved');
        $errorMessage = __('The record was not saved in the database');

        $validateRequest = [
            'value' => 'required|string',
            'label' => 'required|string',
            'is_active' => 'required|boolean',
        ];

        $payload = array_filter($request->all());
        $request->validate($validateRequest);
        $result = $this->modelContactSubject->createRecord($payload);

        return redirect()->route('messages.index')->with('success', $result ? $successMessage : $errorMessage);
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
            'value' => 'sometimes|string',
            'label' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ];

        $payload = array_filter($request->all());
        $request->validate($validateRequest);

        $selectedRecord = $this->modelContactSubject->fetchSingleRecord($request->get('id'));

        $result = $this->modelContactSubject->updateRecord($payload, $id);

        return redirect()->route('messages.index')->with('success', $result ? $successMessage : $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
