<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $modelName;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelName = new User();
    }

    /**
     * Show the authenticated user's profile.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $errorMessage = __('profile.error_message_fetch');

        $displayUserProfile = $this->modelName->fetchCurrentAuthUser() ? $this->modelName->fetchCurrentAuthUser() : $errorMessage;
        return view('profile', compact('displayUserProfile'));
    }

    /**
     * Update the authenticated user's profile information.
     * @param \Illuminate\Http\Request $request The HTTP request object containing the form data.
     * @param int $id The ID of the user record to update.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $successMessage = __('profile.success_message');
        $errorMessage = __('profile.error_message_update');

        $validateRequest = [
            'full_name'     => 'sometimes|string|max:255',
            'first_name'    => 'sometimes|string|max:255',
            'last_name'     => 'sometimes|string|max:255',
            'nickname'      => 'sometimes|string|max:255',
            'profile_image' => 'sometimes|image',
        ];

        $updateRecords = array_filter($request->all());

        if ($request->get('password') !== null)
        {
            $validateRequest['password'] = 'required|string|min:8|confirmed';
            $updateRecords['password'] = Hash::make($request->get('password'));
        }

        if ($request->hasFile('profile_image'))
        {
            $hashFilename = $request->file('profile_image')->hashName();
            $request->profile_image->storeAs('images', $hashFilename, 'public');
            $updateRecords['profile_image'] = 'storage/images/' . $hashFilename;
        }

        $request->validate($validateRequest);

        $result = $this->modelName->updateUser($updateRecords, $id);

        return redirect()->route('profile.index')->with('success', $result ? $successMessage : $errorMessage);
    }
}
