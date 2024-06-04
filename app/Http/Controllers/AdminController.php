<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoogleMaps;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class AdminController extends Controller
{
    protected $googleMaps;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->googleMaps = new GoogleMaps();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all());
        $googleMaps = $this->googleMaps->fetchAllRecords();

        if ($googleMaps instanceof Collection && $googleMaps->isNotEmpty()) {
            $recordGoogleMaps = $googleMaps->toArray()[0];
        }

        $data = [
            'results' => [
                'google_maps' => $recordGoogleMaps,
            ]
        ];

        return view('pages.admin', compact('data'));
    }

    public function storeGoogleMaps(Request $request)
    {
        $validateRequest = [
            'address' => 'required|string|min:3|max:255',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $existingAddress = $this->googleMaps->fetchAllRecords([ 'address' => $payload['address'] ])->first();
        if ($existingAddress) {
            return redirect()->route('index')->with('error', 'You can only create one address.');
        }

        $result = $this->googleMaps->createRecord($payload);

        return redirect()->route('index')->with('success', $result);
    }

    public function updateGoogleMaps(Request $request, string $id)
    {
        $validateRequest = [
            'address' => 'required|string|min:3|max:255',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $result = $this->googleMaps->updateRecord($payload, $id);

        return redirect()->route('index')->with('success', $result);
    }
}
