<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRoleType;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $modelUser;
    protected $modelUserRoleType;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelUser = new User();
        $this->modelUserRoleType = new UserRoleType();
    }

    /**
     * Show the the list of all users and the user role types.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $displayAllRecords = [
            'users' => $this->modelUser->fetchAllUsers(),
            'user_role_types' => $this->modelUserRoleType->fetchAllUserRoleTypes()
        ];
        return view('users', compact('displayAllRecords'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updateRecord = [
            'user_role_type_id' => $request->get('user_role_type_id')
        ];
        $editSingleRecord = $this->modelUser->updateUserRole($updateRecord, $id);

        return redirect()->route('users.index')->with('success', 'The user role was successfully saved!');
    }
}
