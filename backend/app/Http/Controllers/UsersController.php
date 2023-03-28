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
        $errorMessage = __('users_and_roles.error_message_fetch');

        $displayAllRecords = [
            'users' => $this->modelUser->fetchAllUsers() ? $this->modelUser->fetchAllUsers() : $errorMessage,
            'user_role_types' => $this->modelUserRoleType->fetchAllUserRoleTypes() ? $this->modelUserRoleType->fetchAllUserRoleTypes() : $errorMessage
        ];
        return view('users', compact('displayAllRecords'));
    }

    /**
     * Update the specified user's role type in storage.
     * @param Request $request The HTTP request object containing the user role type ID to update.
     * @param int $id The ID of the user to update.
     * @return RedirectResponse The HTTP redirect response after the update is complete.
     */
    public function update(Request $request, int $id)
    {
        $successMessage = __('users_and_roles.success_message');
        $errorMessage = __('users_and_roles.error_message_update');

        $request->validate([
            'user_role_type_id' => 'required',
        ]);
        $updateRecord = [
            'user_role_type_id' => $request->get('user_role_type_id')
        ];
        $result = $this->modelUser->updateUserRole($updateRecord, $id);

        return redirect()->route('users.index')->with('success', $result ? $successMessage : $errorMessage);
    }
}
