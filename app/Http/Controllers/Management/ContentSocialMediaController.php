<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\ContentSocialMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContentSocialMediaController extends Controller
{
    protected $contentSocialMedia;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->contentSocialMedia = new ContentSocialMedia();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'is_active';
        }, ARRAY_FILTER_USE_BOTH);

        $data = [
            'title' => __('Content social media'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->contentSocialMedia->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.content.social.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content social media'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'social.store',
            'results' => [
                [
                    'id' => 1,
                    'key' => 'content_id',
                    'placeholder' => __('Content'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [] // TODO: Bring all the article contents
                ],
                [
                    'id' => 2,
                    'key' => 'platform_name',
                    'placeholder' => __('Platform name'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [
                        [
                            'id' => 1,
                            'value' => 'facebook',
                            'label' => 'Facebook'
                        ]
                    ]
                ],
                [
                    'id' => 3,
                    'key' => 'full_share_url',
                    'placeholder' => __('Full share url'),
                    'type' => 'text',
                    'value' => '',
                ],
            ],
        ];

        return view('pages.admin.management.content.social.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'content_id' => 'required|integer',
            'platform_name' => 'required|string',
            'full_share_url' => 'required|string',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());

        if ($payload['platform_name'] === 'facebook') {
            $payload['full_share_url'] = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($payload['full_share_url']) . '&src=sdkpreparse';
        }

        $payload['user_id'] = Auth::user()->id;
        $result = $this->contentSocialMedia->createRecord($payload);

        return redirect()->route('social.index')->with('success', $result);
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
            'title' => __('Edit a content social media'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'social.update',
            'results' => [
                [
                    'id' => 1,
                    'key' => 'content_id',
                    'placeholder' => __('Content'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [] // TODO: Bring all the article contents
                ],
                [
                    'id' => 2,
                    'key' => 'platform_name',
                    'placeholder' => __('Platform name'),
                    'type' => 'select',
                    'value' => null,
                    'options' => [
                        [
                            'id' => 1,
                            'value' => 'facebook',
                            'label' => 'Facebook'
                        ]
                    ]
                ],
                [
                    'id' => 3,
                    'key' => 'full_share_url',
                    'placeholder' => __('Full share url'),
                    'type' => 'text',
                    'value' => '',
                ],
            ],
        ];

        return view('pages.admin.management.content.social.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'content_id' => 'required|integer',
            'platform_name' => 'required|string',
            'full_share_url' => 'required|string',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());

        if ($payload['platform_name'] === 'facebook') {
            $payload['full_share_url'] = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($payload['full_share_url']) . '&src=sdkpreparse';
        }

        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->contentSocialMedia->fetchSingleRecord($id);
        $result = $this->contentSocialMedia->updateRecord($payload, $id);

        return redirect()->route('social.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
