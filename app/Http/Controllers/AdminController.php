<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
// use App\Models\GoogleMaps;

class AdminController extends Controller
{
    // protected $modelName;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->modelName = new GoogleMaps();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin');
    }

    public function saveGoogleMapsLocation(Request $request)
    {
        $successMessage = __('The record was successfully saved');
        $errorMessage = __('The record was not saved in the database');

        $validateRequest = [
            'google_maps_location' => 'required|string',
        ];
        $payload = array_filter($request->all());
        $request->validate($validateRequest);
        // $result = $this->modelName->createRecord($payload);
        $result = [];

        return redirect()->route('admin.index')->with('success', $result ? $successMessage : $errorMessage);
    }
}
