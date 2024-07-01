<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\Content;
use App\Utilities\FormBuilder;
use App\Utilities\UploadFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected $media;
    protected $mediaType;
    protected $content;
    protected $formBuilder;
    protected $uploadFiles;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->media = new Media();
        $this->mediaType = new MediaType();
        $this->content = new Content();
        $this->formBuilder = new FormBuilder();
        $this->uploadFiles = new UploadFiles();
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
            'actions' => [
                'index' => 'media.index',
                'create' => 'media.create',
                // 'show' => 'media.show',
                'edit' => 'media.edit',
                // 'destroy' => 'media.destroy',
                // 'restore' => 'media.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->media->getInputs()
            ),
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
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a media'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'media.store',
            'results' => $this->formBuilder->handleFormBuilder(
                $this->media->getInputs()
            ),
        ];

        return view('pages.admin.management.media.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'media_type_id' => 'required|integer',
            'content_id' => 'required|integer',
            'internal_path' => 'required|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $mediaType = $this->mediaType->fetchAllRecords([ 'id' => $payload['media_type_id'] ]);
        $payload['internal_path'] = $this->uploadFiles->handleInternalUpload($request, $mediaType);
        $payload['external_path'] = $this->uploadFiles->handleExternalUpload();
        $payload['title'] = $this->uploadFiles->handleTitle();
        $payload['caption'] = $this->uploadFiles->handleCaption();
        $payload['alt_text'] = $this->uploadFiles->handleAltText();
        $payload['description'] = $this->uploadFiles->handleDescription();

        $result = $this->media->createRecord($payload);

        return redirect()->route('media.index')->with('success', $result);
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
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Edit a media'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'media.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->media->getInputs()
            ),
        ];

        $selectedRecord = $this->media->fetchSingleRecord($id);
        $data['results'] = $this->formBuilder->handlePopulateInput($selectedRecord, $data['results']);

        return view('pages.admin.management.media.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'media_type_id' => 'sometimes|integer',
            'content_id' => 'sometimes|integer',
            'internal_path' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;

        $mediaType = $this->mediaType->fetchAllRecords([ 'id' => $payload['media_type_id'] ]);
        $payload['internal_path'] = $this->uploadFiles->handleInternalUpload($request, $mediaType);
        $payload['external_path'] = $this->uploadFiles->handleExternalUpload();
        $payload['title'] = $this->uploadFiles->handleTitle();
        $payload['caption'] = $this->uploadFiles->handleCaption();
        $payload['alt_text'] = $this->uploadFiles->handleAltText();
        $payload['description'] = $this->uploadFiles->handleDescription();

        $result = $this->content->updateRecord($payload, $id);

        return redirect()->route('media.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
