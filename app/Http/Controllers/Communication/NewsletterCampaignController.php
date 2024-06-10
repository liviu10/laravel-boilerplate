<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterTemplate;
use App\Utilities\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsletterCampaignController extends Controller
{
    protected $newsletterCampaign;
    protected $newsletterTemplate;
    protected $formBuilder;

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
        $this->formBuilder = new FormBuilder();
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
            'actions' => [
                'index' => 'campaigns.index',
                'create' => 'campaigns.create',
                'show' => 'campaigns.show',
                'edit' => 'campaigns.edit',
                // 'destroy' => 'campaigns.destroy',
                // 'restore' => 'campaigns.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->newsletterCampaign->getInputs()
            ),
            'results' => $this->newsletterCampaign->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.communication.newsletter.campaigns.index', compact('data'));
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
            'results' => $this->formBuilder->handleFormBuilder(
                $this->newsletterCampaign->getInputs()
            ),
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
            'results' => $this->formBuilder->handleFormBuilder(
                $this->newsletterCampaign->getInputs()
            ),
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
