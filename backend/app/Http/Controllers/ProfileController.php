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
        $request->validate([
            'full_name'  => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'nickname'   => 'required|string|max:255',
            // 'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
        ]);
        $editSingleRecord = $this->modelName->find($id);
        $editSingleRecord->update([
            'full_name'  => $request->get('full_name'),
            'first_name' => $request->get('first_name'),
            'last_name'  => $request->get('last_name'),
            'nickname'   => $request->get('nickname'),
            // 'email'      => $request->get('email'),
            'password'   => Hash::make($request->get('password')),
        ]);

        return redirect()->route('profile.index')->with('success', 'Your profile information was successfully save!');
    }
}
