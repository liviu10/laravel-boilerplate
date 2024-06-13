<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utilities\FormBuilder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $user;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = new User();
        $this->formBuilder = new FormBuilder();
    }

    /**
     * Display a listing of the resource.
     * @return void
     */
    public function index(): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Show the form for creating a new resource.
     * @return void
     */
    public function create(): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Display the specified resource.
     * @return void
     */
    public function show(): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Update a user profile'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'profile.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->user->getInputs()
            ),
        ];

        $selectedRecord = $this->user->fetchSingleRecord($id);
        $data['results'] = $this->formBuilder->handlePopulateInput($selectedRecord, $data['results']);

        foreach ($data['results'] as &$result) {
            foreach ($result as &$item) {
                if ($item['key'] === 'full_name' || $item['key'] === 'created_at') {
                    $item['is_profile'] = false;
                } else {
                    $item['is_profile'] = true;
                }
            }
        }

        return view('pages.admin.settings.users.profile.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'first_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'nickname' => 'sometimes|string|min:3|max:100',
            'email' => 'sometimes|string|min:3|max:255|unique:users',
            'phone' => 'sometimes|string|min:7|max:15|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]&/',
            'password' => 'sometimes|string|min:8|confirmed',
            'profile_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['full_name'] = $payload['first_name'] . ' ' . $payload['last_name'];
        $payload['password'] = Hash::make($this->user->generatePassword());
        $selectedRecord = $this->user->fetchSingleRecord($id);
        $result = $this->user->createRecord($payload);

        return redirect()->route('pages.admin.settings.users.profile.edit')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
