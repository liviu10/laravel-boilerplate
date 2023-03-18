<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $modelName;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelName = new User();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $displayUserProfile = Auth::user();
        return view('profile', compact('displayUserProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
            $updateRecords['profile_image'] = 'storage/images/' . $request->profile_image->getClientOriginalName();
        }

        $request->validate($validateRequest);
        $editSingleRecord = $this->modelName->find($id);

        $editSingleRecord->update($updateRecords);

        return redirect()->route('profile.index')->with('success', 'Your profile information was successfully saved!');
    }
}
