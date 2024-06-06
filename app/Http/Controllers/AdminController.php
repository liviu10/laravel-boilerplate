<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoogleMaps;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $googleMaps;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->googleMaps = new GoogleMaps();
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory
    {
        $googleMaps = $this->googleMaps->fetchAllRecords()->toArray()[0];

        $data = [
            'results' => [
                'google_maps' => $googleMaps,
            ]
        ];

        return view('pages.admin', compact('data'));
    }

    public function storeGoogleMaps(Request $request)
    {
        $validateRequest = [
            'description' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
        ];

        $messages = [
            'description.required' => 'Descrierea evenimentului este obligatorie.',
            'description.string' => 'Descrierea evenimentului trebuie sa fie un text fara caractere speciale.',
            'description.min' => 'Descrierea evenimentului trebuie sa contina minim 3 caractere.',
            'description.max' => 'Descrierea evenimentului trebuie sa contina maxim 255 caractere.',
            'address.required' => 'Adresa evenimentului este obligatorie.',
            'address.string' => 'Adresa evenimentului trebuie sa fie un text fara caractere speciale.',
            'address.min' => 'Adresa evenimentului trebuie sa contina minim 3 caractere.',
            'address.max' => 'Adresa evenimentului trebuie sa contina maxim 255 caractere.',
        ];

        $request->validate($validateRequest, $messages);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $existingAddress = $this->googleMaps->fetchAllRecords([ 'address' => $payload['address'] ])->first();
        if ($existingAddress) {
            return redirect()->route('index')->with('error', 'You can only create one address.');
        }

        $result = $this->googleMaps->createRecord($payload);

        return redirect()->route('index')->with('success', $result);
    }

    public function storeUserProfile(Request $request)
    {
        $validateRequest = [
            'first_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'sometimes|string|min:7|max:15|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['full_name'] = $payload['first_name'] . ' ' . $payload['last_name'];
        $payload['user_id'] = Auth::user()->id;
        $result = $this->user->createRecord($payload);

        return redirect()->route('index')->with('success', $result);
    }

    public function updateGoogleMaps(Request $request, string $id)
    {
        $validateRequest = [
            'description' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
        ];

        $messages = [
            'description.required' => 'Descrierea evenimentului este obligatorie.',
            'description.string' => 'Descrierea evenimentului trebuie sa fie un text fara caractere speciale.',
            'description.min' => 'Descrierea evenimentului trebuie sa contina minim 3 caractere.',
            'description.max' => 'Descrierea evenimentului trebuie sa contina maxim 255 caractere.',
            'address.required' => 'Adresa evenimentului este obligatorie.',
            'address.string' => 'Adresa evenimentului trebuie sa fie un text fara caractere speciale.',
            'address.min' => 'Adresa evenimentului trebuie sa contina minim 3 caractere.',
            'address.max' => 'Adresa evenimentului trebuie sa contina maxim 255 caractere.',
        ];

        $request->validate($validateRequest, $messages);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $result = $this->googleMaps->updateRecord($payload, $id);

        return redirect()->route('index')->with('success', $result);
    }

    public function updateUserProfile(Request $request, string $id)
    {
        $validateRequest = [
            'first_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'sometimes|string|min:3|max:255|unique:users',
            'phone' => 'sometimes|string|min:7|max:15|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $result = $this->googleMaps->updateRecord($payload, $id);

        return redirect()->route('index')->with('success', $result);
    }
}
