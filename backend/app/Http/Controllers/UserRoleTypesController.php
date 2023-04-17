<?php

namespace App\Http\Controllers;

use App\Models\UserRoleType;
use Illuminate\Http\Request;

class UserRoleTypesController extends Controller
{
    protected $modelUserRoleType;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modelUserRoleType = new UserRoleType();
    }

    /**
     * Display a list of all user role types.
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @return \Illuminate\Contracts\Support\Renderable A renderable view.
     */
    public function index(Request $request)
    {
        $errorMessage = __('admin.general.error_message_fetch');

        $searchTerms = array_filter($request->except('page'));
        $results = $this->modelUserRoleType->fetchAllUserRoleTypes($searchTerms);

        $searchMessage = __('admin.general.search_results_label') . ' (';
        foreach ($searchTerms as $key => $value) {
            if ($key === 'is_active')
            {
                if ($value === '1')
                {
                    $value = __('admin.general.yes_label');
                }
                else
                {
                    $value = __('admin.general.no_label');
                }
            }
            $searchMessage .= "$key: $value, ";
        }
        $searchMessage = rtrim($searchMessage, ', ') . ')';
        $displayAllRecords = $results ?: $errorMessage;

        return view('user-roles', compact('displayAllRecords', 'searchTerms', 'searchMessage'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request The HTTP request object containing the user role type data to store.
     * @return RedirectResponse The HTTP redirect response after the store is complete.
     */
    // public function store(Request $request)
    // {
    //     $successMessage = __('users_and_roles.success_message');
    //     $errorMessage = __('users_and_roles.error_message_update');

    //     $validateRequest = [
    //         'user_role_name'        => 'required|string|min:3|max:100',
    //         'user_role_description' => 'required|string|min:3',
    //         'is_active'             => [
    //             'required',
    //             function ($attribute, $value, $fail) {
    //                 if (!is_bool($value)) {
    //                     $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    //                 }
    //                 if (!is_bool($value)) {
    //                     $fail($attribute . ' must be a boolean.');
    //                 }
    //             }
    //         ],
    //     ];
    //     $saveRecords = $request->all();
    //     $request->validate($validateRequest);

    //     $result = $this->modelUserRoleType->saveUserRole($saveRecords);

    //     return redirect()->route('user-roles.index')->with('success', $result ? $successMessage : $errorMessage);
    // }

    /**
     * Update the user role type in storage.
     * @param Request $request The HTTP request object containing the user role type ID to update.
     * @param int $id The ID of the user to update.
     * @return RedirectResponse The HTTP redirect response after the update is complete.
     */
    public function update(Request $request, int $id)
    {
        $successMessage = __('admin.general.success_message');
        $errorMessage = __('admin.general.error_message_update');

        $request->validate([
            'user_role_name'        => 'sometimes|string|min:3|max:100',
            'user_role_description' => 'sometimes|string|min:3',
            'is_active'             => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_bool($value)) {
                        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    }
                    if (!is_bool($value)) {
                        $fail($attribute . ' must be a boolean.');
                    }
                }
            ],
        ]);
        $updateRecord = [
            'user_role_name'        => $request->get('user_role_name'),
            'user_role_description' => $request->get('user_role_description'),
            'is_active'             => $request->get('is_active')
        ];
        $result = $this->modelUserRoleType->updateUserRole($updateRecord, $id);

        return redirect()->route('user-roles.index')->with('success', $result ? $successMessage : $errorMessage);
    }
}
