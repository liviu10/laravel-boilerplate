<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentCategory;
use App\Models\ContentVisibility;
use App\Models\ContentType;
use App\Models\ContentSocialMedia;
use App\Utilities\FormBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Exception;

class ContentController extends Controller
{
    protected $content;
    protected $contentCategory;
    protected $contentVisibility;
    protected $contentType;
    protected $contentSocialMedia;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->content = new Content();
        $this->contentCategory = new ContentCategory();
        $this->contentVisibility = new ContentVisibility();
        $this->contentType = new ContentType();
        $this->contentSocialMedia = new ContentSocialMedia();
        $this->formBuilder = new FormBuilder();
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
            'actions' => [
                'index' => 'content.index',
                'create' => 'content.create',
                'show' => 'content.show',
                'edit' => 'content.edit',
                // 'destroy' => 'content.destroy',
                // 'restore' => 'content.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->content->getInputs()
            ),
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

    /**
     * Show the form for creating a new resource.
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $data = [
            'title' => __('Create a content'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'content.store',
            'results' => $this->formBuilder->handleFormBuilder(
                $this->content->getInputs()
            ),
        ];

        return view('pages.admin.management.content.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'content_category_id' => 'required|integer',
            'scheduled_on' => 'sometimes',
            'content_visibility_id' => 'required|integer',
            'title' => 'required|string|min:3|max:255',
            'content_type_id' => 'required|integer',
            'description' => 'sometimes|string|min:3|max:255',
            'content' => 'required|string',
            'allow_comments' => 'required|boolean',
            'allow_share' => 'required|boolean',
            'is_admin' => 'required|boolean',
            'is_guest_home' => 'required|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());

        if (!array_key_exists('scheduled_on', $payload)) {
            $payload['scheduled_on'] = null;
        }
        $payload['content_url'] = config('app.url') .
            ($payload['content_type_id'] === "2" ? '/blog/article' : '') .
            '/' . str_replace(' ', '-', strtolower($payload['title']));
        $payload['content_slug'] = str_replace(' ', '-', strtolower($payload['title']));
        if (!array_key_exists('allow_comments', $payload)) {
            $payload['allow_comments'] = 0;
        }
        if (!array_key_exists('allow_share', $payload)) {
            $payload['allow_share'] = 0;
        }
        if (!array_key_exists('is_admin', $payload)) {
            $payload['is_admin'] = 0;
        }
        if (!array_key_exists('is_guest_home', $payload)) {
            $payload['is_guest_home'] = 0;
        }
        $payload['user_id'] = Auth::user()->id;
        $result = $this->content->createRecord($payload);

        if (array_key_exists('allow_share', $payload) && $payload['allow_share']) {
            $this->contentSocialMedia->insert($this->handleSocialMediaPayload($result));
        }

        return redirect()->route('content.index')->with('success', $result);
    }

    private function handleSocialMediaPayload(Content|Exception $result): array|bool
    {
        if ($result instanceof Content) {
            $socialMediaPlatforms = ['Facebook', 'Twitter', 'Linkedin', 'Whatsapp'];
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
                    case 'Whatsapp':
                        $socialMediaPayload['full_share_url'] = 'https://api.whatsapp.com/send?text=' . urlencode($result->content_url);
                        break;
                }
                $socialMediaPayloads[] = $socialMediaPayload;
            }

            return $socialMediaPayloads;
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
            'title' => __('Show a content'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->content->fetchSingleRecord($id),
        ];

        return view('pages.admin.management.content.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Edit a content'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'content.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->content->getInputs()
            ),
        ];

        $selectedRecord = $this->content->fetchSingleRecord($id);
        $data['results'] = $this->formBuilder->handlePopulateInput($selectedRecord, $data['results']);

        return view('pages.admin.management.content.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'content_category_id' => 'required|integer',
            'scheduled_on' => 'sometimes',
            'content_visibility_id' => 'required|integer',
            'title' => 'required|string|min:3|max:255',
            'content_type_id' => 'required|integer',
            'description' => 'sometimes|string',
            'content' => 'required|string',
            'allow_comments' => 'sometimes|boolean',
            'allow_share' => 'sometimes|boolean',
            'is_admin' => 'sometimes|boolean',
            'is_guest_home' => 'sometimes|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());

        if (!array_key_exists('scheduled_on', $payload)) {
            $payload['scheduled_on'] = null;
        }
        $payload['content_url'] = config('app.url') .
            ($payload['content_type_id'] === "2" ? '/blog/article' : '') .
            '/' . str_replace(' ', '-', strtolower($payload['title']));
        $payload['content_slug'] = str_replace(' ', '-', strtolower($payload['title']));
        if (!array_key_exists('allow_comments', $payload)) {
            $payload['allow_comments'] = 0;
        }
        if (!array_key_exists('allow_share', $payload)) {
            $payload['allow_share'] = 0;
        }
        if (!array_key_exists('is_admin', $payload)) {
            $payload['is_admin'] = 0;
        }
        if (!array_key_exists('is_guest_home', $payload)) {
            $payload['is_guest_home'] = 0;
        }
        $payload['user_id'] = Auth::user()->id;
        $result = $this->content->updateRecord($payload, $id);

        if (array_key_exists('allow_share', $payload) && $payload['allow_share']) {
            foreach($this->handleSocialMediaPayload($result) as $payload) {
                $this->contentSocialMedia->updateRecord($payload, $id);
            }
        }

        return redirect()->route('content.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
