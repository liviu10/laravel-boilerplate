<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected $media;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->media = new Media();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all());

        $data = [
            'title' => __('Media'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'shortcuts' => [
                $this->handleShortcuts()
            ],
            'results' => $this->media->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.media.index', compact('data'));
    }

    private function handleShortcuts(): array
    {
        return [
            [
                'id' => 1,
                'title' => __('Media types'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => url('admin/management/media/types')
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
