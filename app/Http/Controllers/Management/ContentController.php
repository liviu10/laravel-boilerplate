<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentSocialMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Exception;

class ContentController extends Controller
{
    protected $content;
    protected $contentSocialMedia;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->content = new Content();
        $this->contentSocialMedia = new ContentSocialMedia();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'allow_comments' || $key === 'allow_share';
        }, ARRAY_FILTER_USE_BOTH);

        $data = [
            'title' => __('Content'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'shortcuts' => [
                $this->handleShortcuts()
            ],
            'results' => $this->content->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.management.content.index', compact('data'));
    }

    private function handleShortcuts(): array
    {
        return [
            [
                'id' => 1,
                'title' => __('Category'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => url('admin/management/content/categories')
            ],
            [
                'id' => 2,
                'title' => __('Types'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => url('admin/management/content/types')
            ],
            [
                'id' => 3,
                'title' => __('Visibility'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => url('admin/management/content/visibilities')
            ],
            [
                'id' => 4,
                'title' => __('Comment types'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => url('admin/management/comment/types')
            ],
            [
                'id' => 5,
                'title' => __('Comment statuses'),
                'short_description' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
                'url' => url('admin/management/comment/statuses')
            ],
        ];
    }

    private function handleFormInputs(): array
    {
        return [
            [
                'id' => 1,
                'key' => 'content_visibility_id',
                'placeholder' => __('Visibility'),
                'type' => 'select',
                'value' => null,
                'options' => [], // TODO: bring the content visibilities as value and label
            ],
            [
                'id' => 2,
                'key' => 'title',
                'placeholder' => __('Title'),
                'type' => 'text',
                'value' => '',
            ],
            [
                'id' => 3,
                'key' => 'content_type_id',
                'placeholder' => __('Type'),
                'type' => 'select',
                'value' => null,
                'options' => [], // TODO: bring the content types as value and label
            ],
            [
                'id' => 4,
                'key' => 'description',
                'placeholder' => __('Description'),
                'type' => 'text',
                'value' => '',
            ],
            [
                'id' => 5,
                'key' => 'content',
                'placeholder' => __('Content'),
                'type' => 'textarea',
                'value' => '',
            ],
            [
                'id' => 6,
                'key' => 'allow_comments',
                'placeholder' => __('Allow comments'),
                'type' => 'select',
                'value' => null,
                'options' => [
                    [
                        'id' => 1,
                        'value' => 0,
                        'label' => __('No'),
                    ],
                    [
                        'id' => 2,
                        'value' => 1,
                        'label' => __('Yes'),
                    ]
                ],
            ],
            [
                'id' => 7,
                'key' => 'allow_share',
                'placeholder' => __('Allow share'),
                'type' => 'select',
                'value' => null,
                'options' => [
                    [
                        'id' => 1,
                        'value' => 0,
                        'label' => __('No'),
                    ],
                    [
                        'id' => 2,
                        'value' => 1,
                        'label' => __('Yes'),
                    ]
                ],
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
            'title' => __('Create a content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'content.store',
            'results' => $this->handleFormInputs(),
        ];

        return view('pages.admin.management.content.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'content_visibility_id' => 'sometimes|integer',
            'title' => 'sometimes|string|min:3|max:255',
            'content_type_id' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'content' => 'sometimes|string',
            'allow_comments' => 'sometimes|boolean',
            'allow_share' => 'sometimes|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['content_url'] = config('app.url') .
            ($payload['content_type_id'] === 2 ? '/blog' : '') .
            '/' . str_replace(' ', '-', strtolower($payload['title']));
        $payload['user_id'] = Auth::user()->id;
        $result = $this->content->createRecord($payload);
        $this->contentSocialMedia->insert($this->handleSocialMediaPayload($result));

        return redirect()->route('contents.index')->with('success', $result);
    }

    private function handleSocialMediaPayload(Content|Exception $result): array|bool
    {
        if ($result instanceof Content) {
            $socialMediaPlatforms = ['Facebook', 'Twitter', 'Linkedin'];
            $socialMediaPayload = [];
            foreach ($socialMediaPlatforms as $platform) {
                $socialMediaPayload = [
                    'content_id' => $result->id,
                    'platform_name' => $platform,
                    'user_id' => Auth::user()->id,
                ];
                switch ($platform) {
                    case 'Facebook':
                        $socialMediaPayload['full_share_url'] = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($result->content_url) . '&src=sdkpreparse';
                        break;
                    case 'Twitter':
                        $socialMediaPayload['full_share_url'] = 'http://twitter.com/share?text=' . $result->title . '&url=' . urlencode($result->content_url);
                        break;
                    case 'Linkedin':
                        $socialMediaPayload['full_share_url'] = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($result->content_url) . '&title=' . $result->title .'&source=LinkedIn';
                        break;
                }
                $socialMediaPayloads[] = $socialMediaPayload;
            }

            return $socialMediaPayload;
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Show a newsletter subscriber'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->content->fetchSingleRecord($id),
        ];

        return view('pages.admin.management.content.create', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content type'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'content.update',
            'results' => $this->handleFormInputs(),
        ];

        return view('pages.admin.management.content.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'content_visibility_id' => 'required|integer',
            'title' => 'required|string|min:3|max:255',
            'content_type_id' => 'required|integer',
            'description' => 'sometimes|string',
            'content' => 'required|string',
            'allow_comments' => 'required|boolean',
            'allow_share' => 'required|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['content_url'] = config('app.url') .
            ($payload['content_type_id'] === 2 ? '/blog' : '') .
            '/' . str_replace(' ', '-', strtolower($payload['title']));
        $payload['user_id'] = Auth::user()->id;
        $selectedRecord = $this->content->fetchSingleRecord($id);
        $result = $this->content->updateRecord($payload, $id);
        foreach($this->handleSocialMediaPayload($result) as $payload) {
            $this->contentSocialMedia->updateRecord($payload, $id);
        }

        return redirect()->route('contents.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
