<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRoleType;
use Illuminate\Http\Request;

class UsersController extends Controller
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
        $displayAllRecords = [
            'users' => User::with([
                'user_role_type' => function ($query) {
                    $query->select('*');
                }
            ])->get(),
            'user_role_types' => UserRoleType::select('id', 'user_role_name')->get()
        ];
        return view('users', compact('displayAllRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd([
            'request' => $request->all(),
            'id' => $id
        ]);
        $editSingleRecord = $this->modelName->find($id);
        $editSingleRecord->update([
            'user_role_type_id' => $request->get('id'),
        ]);

        return redirect()->route('users.index')->with('success', 'The user role was successfully saved!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
