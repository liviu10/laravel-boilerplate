<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\Content;
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
                'show' => 'media.show',
                'edit' => 'media.edit',
                // 'destroy' => 'media.destroy',
                // 'restore' => 'media.restore',
            ],
            'filter_form' => [
                'action' => 'media.index',
                'inputs' => $this->handleFormInputs(),
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

    private function handleFormInputs(): array
    {
        return [
            [
                'id' => 1,
                'key' => 'media_type_id',
                'placeholder' => __('Type'),
                'type' => 'select',
                'value' => null,
                'options' => $this->mediaType->fetchAllRecords()->toArray(),
            ],
            [
                'id' => 2,
                'key' => 'content_id',
                'placeholder' => __('Content'),
                'type' => 'select',
                'value' => null,
                'options' => $this->content->fetchAllRecords()->toArray(),
            ],
            [
                'id' => 3,
                'key' => 'title',
                'placeholder' => __('Title'),
                'type' => 'text',
                'value' => '',
            ],
            [
                'id' => 4,
                'key' => 'caption',
                'placeholder' => __('Caption'),
                'type' => 'text',
                'value' => '',
            ],
            [
                'id' => 5,
                'key' => 'alt_text',
                'placeholder' => __('Alternative text'),
                'type' => 'text',
                'value' => '',
            ],
            [
                'id' => 6,
                'key' => 'description',
                'placeholder' => __('Description'),
                'type' => 'text',
                'value' => '',
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
            'results' => $this->handleFormInputs(),
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
            'internal_path' => 'sometimes|string',
            'external_path' => 'sometimes|string',
            'title' => 'sometimes|string|min:3|max:255',
            'caption' => 'sometimes|string|min:3|max:255',
            'alt_text' => 'sometimes|string|min:3|max:255',
            'description' => 'sometimes|string|min:3|max:255',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->content->createRecord($payload);

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
            'results' => $this->handleFormInputs(),
        ];

        $selectedRecord = $this->media->fetchSingleRecord($id);
        foreach ($data['results'] as &$result) {
            foreach ($selectedRecord->toArray()[0] as $recordKey => $recordValue) {
                if ($result['key'] === $recordKey) {
                    $result['value'] = $recordValue;
                    break;
                }
            }
        }

        return view('pages.admin.management.media.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'media_type_id' => 'required|integer',
            'content_id' => 'required|integer',
            'internal_path' => 'sometimes|string',
            'external_path' => 'sometimes|string',
            'title' => 'sometimes|string|min:3|max:255',
            'caption' => 'sometimes|string|min:3|max:255',
            'alt_text' => 'sometimes|string|min:3|max:255',
            'description' => 'sometimes|string|min:3|max:255',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->content->createRecord($payload);

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
