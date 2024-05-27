<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all());

        $data = [
            'title' => __('Users'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->user->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.settings.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a user'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'users.store',
            'results' => [
                [
                    'id' => 1,
                    'key' => 'first_name',
                    'placeholder' => __('First name'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 2,
                    'key' => 'last_name',
                    'placeholder' => __('Last name'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 3,
                    'key' => 'email',
                    'placeholder' => __('Email'),
                    'type' => 'email',
                    'value' => '',
                ],
            ],
        ];

        return view('pages.admin.settings.users.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'first_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|min:3|max:255|unique:users',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['full_name'] = $payload['first_name'] . ' ' . $payload['last_name'];
        $payload['user_id'] = Auth::user()->id;
        $result = $this->user->createRecord($payload);

        return redirect()->route('pages.admin.settings.users.index')->with('success', $result);
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
            'results' => $this->user->fetchSingleRecord($id),
        ];

        return view('pages.admin.settings.users.create', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function edit(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'users.update',
            'results' => [
                [
                    'id' => 1,
                    'key' => 'first_name',
                    'placeholder' => __('First name'),
                    'type' => 'text',
                    'value' => '',
                ],
                [
                    'id' => 2,
                    'key' => 'last_name',
                    'placeholder' => __('Last name'),
                    'type' => 'text',
                    'value' => '',
                ],
            ],
        ];

        return view('pages.admin.settings.users.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'first_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['full_name'] = $payload['first_name'] . ' ' . $payload['last_name'];
        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->user->fetchSingleRecord($id);
        $result = $this->user->createRecord($payload);

        return redirect()->route('pages.admin.settings.users.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(405, __('The action is not allowed.'));
    }
}
