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
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $errorMessage = __('admin.general.error_message_fetch');

        $searchTerms = array_filter($request->except('page'));
        $results = [
            'users' => $this->modelUser->fetchAllUsers($searchTerms),
            'user_role_types' => $this->modelUserRoleType->fetchAllUserRoleTypeNames()
        ];
        $searchMessage = __('admin.general.search_results_label') . ' (';
        $keyNames = [
            'user_role_type_id' => 'user_role_type'
        ];
        foreach ($searchTerms as $key => $value) {
            if (array_key_exists($key, $keyNames)) {
                $key = $keyNames[$key];
                if ($key === 'user_role_type') {
                    $value = $results['user_role_types']->firstWhere('id', $value)?->toArray()['user_role_name'];
                }
            }
            $searchMessage .= "$key: $value, ";
        }
        $searchMessage = rtrim($searchMessage, ', ') . ')';
        $displayAllRecords = $results ?: $errorMessage;

        return view('users', compact('displayAllRecords', 'searchTerms', 'searchMessage'));
    }

    /**
     * Update the specified user's role type in storage.
     * @param Request $request The HTTP request object containing the user role type ID to update.
     * @param int $id The ID of the user to update.
     * @return RedirectResponse The HTTP redirect response after the update is complete.
     */
    public function update(Request $request, int $id)
    {
        $successMessage = __('admin.general.success_message');
        $errorMessage = __('admin.general.error_message_update');

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
