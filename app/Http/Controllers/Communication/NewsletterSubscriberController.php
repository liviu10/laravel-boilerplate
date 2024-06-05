<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Mail\UpdateNewsletterEnrolment;
use App\Models\NewsletterCampaign;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    protected $newsletterSubscriber;
    protected $newsletterCampaign;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->newsletterSubscriber = new NewsletterSubscriber();
        $this->newsletterCampaign = new NewsletterCampaign();
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'privacy_policy' || $key === 'terms_and_conditions';
        }, ARRAY_FILTER_USE_BOTH);

        $data = [
            'title' => __('Newsletter subscribers'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'subscribers.index',
                // 'create' => 'subscribers.create',
                'show' => 'subscribers.show',
                'edit' => 'subscribers.edit',
                // 'destroy' => 'subscribers.destroy',
                // 'restore' => 'subscribers.restore',
            ],
            'filter_form' => [
                'action' => 'subscribers.index',
                'inputs' => $this->handleFormInputs(),
            ],
            'results' => $this->newsletterSubscriber->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.communication.newsletter.subscribers.index', compact('data'));
    }

    private function handleFormInputs(): array
    {
        return [
            [
                'id' => 1,
                'key' => 'newsletter_campaign_id',
                'placeholder' => __('Newsletter campaign'),
                'type' => 'select',
                'value' => null,
                'options' => $this->newsletterCampaign
                    ->fetchAllRecords()
                    ->map(function ($campaign) {
                        return [
                            'value' => $campaign->id,
                            'label' => $campaign->name,
                        ];
                    })
                    ->toArray(),
            ],
            [
                'id' => 2,
                'key' => 'full_name',
                'placeholder' => __('Full name'),
                'type' => 'text',
                'value' => ''
            ],
            [
                'id' => 3,
                'key' => 'email',
                'placeholder' => __('Email'),
                'type' => 'mail',
                'value' => ''
            ],
            [
                'id' => 4,
                'key' => 'privacy_policy',
                'placeholder' => __('Privacy policy'),
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
                'id' => 5,
                'key' => 'terms_and_conditions',
                'placeholder' => __('Terms and conditions'),
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
                'id' => 6,
                'key' => 'data_protection',
                'placeholder' => __('Data protection'),
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
                'key' => 'valid_email',
                'placeholder' => __('Valid email'),
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
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(405, __('The action is not allowed.'));
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
            'results' => $this->newsletterSubscriber->fetchSingleRecord($id),
        ];

        return view('pages.admin.communication.newsletter.subscribers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Edit a newsletter subscriber'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'subscribers.update',
            'rowId' => $id,
            'results' => [
                [
                    'id' => 1,
                    'key' => 'newsletter_campaign_id',
                    'placeholder' => __('Newsletter campaign'),
                    'type' => 'select',
                    'value' => null,
                    'options' => $this->newsletterCampaign
                        ->fetchAllRecords()
                        ->map(function ($campaign) {
                            return [
                                'value' => $campaign->id,
                                'label' => $campaign->name,
                            ];
                        })
                        ->toArray(),
                ],
            ],
        ];

        $selectedRecord = $this->newsletterSubscriber->fetchSingleRecord($id);
        foreach ($data['results'] as &$result) {
            foreach ($selectedRecord->toArray()[0] as $recordKey => $recordValue) {
                if ($result['key'] === $recordKey) {
                    $result['value'] = $recordValue;
                    break;
                }
            }
        }

        return view('pages.admin.communication.newsletter.subscribers.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'newsletter_campaign_id' => 'required|array',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->newsletterSubscriber->updateRecord($payload, $id);

        if ($result instanceof NewsletterSubscriber) {
            $newsletterSubscriber = $this->newsletterSubscriber->fetchSingleRecord($payload['contact_message_id'])->toArray();
            Mail::to($newsletterSubscriber['email'])->send(new UpdateNewsletterEnrolment($newsletterSubscriber));
        }

        return redirect()->route('subscribers.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }
}
