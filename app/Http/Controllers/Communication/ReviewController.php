<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Review;
use App\Mail\SendReviewToUser;
use App\Utilities\FormBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $review;
    protected $formBuilder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->review = new Review();
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
            'title' => __('Reviews'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'actions' => [
                'index' => 'subscribers.index',
                // 'create' => 'subscribers.create',
                // 'show' => 'subscribers.show',
                'edit' => 'subscribers.edit',
                // 'destroy' => 'subscribers.destroy',
                // 'restore' => 'subscribers.restore',
            ],
            'forms' => $this->formBuilder->handleFormBuilder(
                $this->review->getInputs()
            ),
            'results' => $this->review->fetchAllRecords($searchTerms),
        ];

        return view('pages.admin.communication.reviews.index', compact('data'));
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
        abort(405, __('The action is not allowed.'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View|Application|Factory
     */
    public function edit(string $id): View|Application|Factory
    {
        $data = [
            'title' => __('Edit a review'),
            'description' => __('
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            '),
            'action' => 'reviews.update',
            'rowId' => $id,
            'results' => $this->formBuilder->handleFormBuilder(
                $this->review->getInputs()
            ),
        ];

        $selectedRecord = $this->review->fetchSingleRecord($id);
        foreach ($data['results'] as &$result) {
            foreach ($selectedRecord->toArray()[0] as $recordKey => $recordValue) {
                if ($result['key'] === $recordKey) {
                    $result['value'] = $recordValue;
                    break;
                }
            }
        }

        return view('pages.admin.communication.reviews.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateRequest = [
            'is_active' => 'sometimes|nullable|boolean',
        ];

        $request->validate($validateRequest);
        $payload = array_filter($request->all());
        $payload['user_id'] = Auth::user()->id;
        $result = $this->review->updateRecord($payload, $id);

        return redirect()->route('reviews.index')->with('success', $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        abort(405, __('The action is not allowed.'));
    }

    public function sendReview(Request $request)
    {
        $searchTerms = array_filter($request->all(), function ($value, $key) {
            return !is_null($value) || $key === 'is_active';
        }, ARRAY_FILTER_USE_BOTH);

        if (array_key_exists('resource', $searchTerms)) {
            if ($searchTerms['resource'] === 'contact-message' && array_key_exists('contact_message_ids', $searchTerms)) {
                $contactMessage = new ContactMessage();
                $result = $contactMessage->fetchAllRecords($searchTerms['contact_message_ids']);
                if ($result instanceof Collection && $result->isNotEmpty()) {
                    foreach ($result as $key => $item) {
                        Mail::to($item['email'])->send(new SendReviewToUser($item));
                    }
                }
            }

            if ($searchTerms['resource'] === 'newsletter-subscribers' && array_key_exists('newsletter_subscriber_ids', $searchTerms)) {
                $newsletterSubscriber = new NewsletterSubscriber();
                $result = $newsletterSubscriber->fetchAllRecords($searchTerms['newsletter_subscriber_ids']);
                if ($result instanceof Collection && $result->isNotEmpty()) {
                    foreach ($result as $key => $item) {
                        Mail::to($item['email'])->send(new SendReviewToUser($item));
                    }
                }
            }
        }
    }
}
