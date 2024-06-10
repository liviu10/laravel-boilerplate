<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Mail\UpdateNewsletterEnrolment;
use App\Models\NewsletterCampaign;
use App\Utilities\FormBuilder;
use App\Utilities\ValidateEmail;
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
    protected $formBuilder;
    protected $validateEmail;

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
        $this->formBuilder = new FormBuilder();
        $this->validateEmail = new ValidateEmail();
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
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->newsletterSubscriber->getInputs()
            ),
            'results' => $this->newsletterSubscriber->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.communication.newsletter.subscribers.index', compact('data'));
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
            'results' => $this->formBuilder->handleFormBuilder(
                $this->newsletterSubscriber->getInputs()
            ),
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
