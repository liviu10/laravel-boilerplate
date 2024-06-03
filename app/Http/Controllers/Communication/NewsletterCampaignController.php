<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsletterCampaignController extends Controller
{
    protected $newsletterCampaign;
    protected $newsletterTemplate;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->newsletterCampaign = new NewsletterCampaign();
        $this->newsletterTemplate = new NewsletterTemplate();
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
            'title' => __('Newsletter campaigns'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->newsletterCampaign->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.communication.newsletter.campaigns.index', compact('data'));
    }

    private function handleFormInputs(): array
    {
        return [
            [
                'id' => 1,
                'key' => 'name',
                'placeholder' => __('Name'),
                'type' => 'text',
                'value' => ''
            ],
            [
                'id' => 2,
                'key' => 'description',
                'placeholder' => __('Description'),
                'type' => 'text',
                'value' => ''
            ],
            [
                'id' => 3,
                'key' => 'is_active',
                'placeholder' => __('Is active?'),
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
                'id' => 4,
                'key' => 'valid_from',
                'placeholder' => __('Valid from'),
                'type' => 'datetime-local',
                'value' => '',
                'min' => Carbon::now()->startOfYear()->toDateTimeLocalString(),
            ],
            [
                'id' => 5,
                'key' => 'valid_to',
                'placeholder' => __('Valid to'),
                'type' => 'datetime-local',
                'value' => '',
                'min' => Carbon::now()->startOfYear()->toDateTimeLocalString(),
            ],
            [
                'id' => 5,
                'key' => 'occur_times',
                'placeholder' => __('Occur times'),
                'type' => 'number',
                'value' => 0,
                'min' => 1,
                'max' => 30,
            ],
            [
                'id' => 6,
                'key' => 'occur_week',
                'placeholder' => __('Occur week'),
                'type' => 'number',
                'value' => 0,
                'min' => 1,
                'max' => 7,
            ],
            [
                'id' => 7,
                'key' => 'occur_day',
                'placeholder' => __('Occur day'),
                'type' => 'number',
                'value' => 0,
                'min' => 1,
                'max' => 31,
            ],
            [
                'id' => 8,
                'key' => 'occur_hour',
                'placeholder' => __('Occur hour'),
                'type' => 'time',
                'value' => '',
                'min' => '00:00',
                'max' => '23:59',
            ],
            [
                'id' => 9,
                'key' => 'template',
                'placeholder' => __('Template'),
                'type' => 'textarea',
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
            'title' => __('Create a newsletter campaign'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'campaigns.store',
            'results' => $this->handleFormInputs(),
        ];

        return view('pages.admin.communication.newsletter.campaigns.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = [
            'name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'description' => 'sometimes|string',
            'is_active' => 'sometimes|nullable|boolean',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'occur_times' => 'required|integer|min:1',
            'occur_week' => 'required|integer|min:1',
            'occur_day' => 'required|integer|min:1',
            'occur_hour' => 'required|date_format:H:i:s',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->newsletterCampaign->createRecord($payload);
        $this->newsletterTemplate->createRecord([
            'newsletter_campaign_id' => $result->id,
            'is_active' => 1,
            'template' => $request->get('template'),
        ]);

        return redirect()->route('campaigns.index')->with('success', $result);
    }

    /**
     * Display the specified resource.
     * @return View|Application|Factory
     */
    public function show(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Show a newsletter campaign'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'results' => $this->newsletterCampaign->fetchSingleRecord($id),
        ];

        return view('pages.admin.communication.newsletter.campaigns.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Edit a newsletter campaign'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'campaigns.update',
            'rowId' => $id,
            'results' => $this->handleFormInputs(),
        ];

        $selectedRecord = $this->newsletterCampaign->fetchSingleRecord($id);
        foreach ($data['results'] as &$result) {
            foreach ($selectedRecord->toArray()[0] as $recordKey => $recordValue) {
                if ($result['key'] === $recordKey) {
                    $result['value'] = $recordValue;
                    break;
                }
            }
        }

        return view('pages.admin.communication.newsletter.campaigns.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'description' => 'sometimes|string',
            'is_active' => 'sometimes|nullable|boolean',
            'valid_from' => 'sometimes',
            'valid_to' => 'sometimes',
            'occur_times' => 'sometimes|integer|min:1',
            'occur_week' => 'sometimes|integer|min:1',
            'occur_day' => 'sometimes|integer|min:1',
            'occur_hour' => 'sometimes|date_format:H:i:s',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->newsletterCampaign->updateRecord($payload, $id);
        $this->newsletterTemplate->updateRecord([
            'newsletter_campaign_id' => $result->id,
            'is_active' => 1,
            'template' => $request->get('template'),
        ], $result->newsletter_templates->id);

        return redirect()->route('campaigns.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
