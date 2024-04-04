<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmContactMessage;
use App\Http\Requests\ContactMessageRequest;
use App\Http\Requests\NewsletterSubscriberRequest;
use App\Http\Requests\ReviewRequest;
use App\Models\ContactMessage;
use App\Models\ContactSubject;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use App\Models\Review;
use App\Utilities\HandleApi;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CommunicationController extends Controller
{
    protected ContactSubject $modelContactSubject;
    protected ContactMessage $modelContactMessage;
    protected NewsletterCampaign $modelNewsletterCampaign;
    protected NewsletterSubscriber $modelNewsletterSubscriber;
    protected Review $modelReview;
    protected HandleApi $handleApi;

    public function __construct()
    {
        $this->modelContactSubject = new ContactSubject();
        $this->modelContactMessage = new ContactMessage();
        $this->modelNewsletterCampaign = new NewsletterCampaign();
        $this->modelNewsletterSubscriber = new NewsletterSubscriber();
        $this->modelReview = new Review();
        $this->handleApi = new HandleApi();
    }

    /**
     * Get all active contact subjects.
     *
     * @return Response|ResponseFactory
     */
    public function getContactSubjects(): Response|ResponseFactory
    {
        $query = $this->modelContactSubject->fetchAllRecords();

        return $this->handleApi->handleApiResponse($query);
    }

    /**
     * Send a new contact message.
     *
     * @param ContactMessageRequest $request
     * @return Response|ResponseFactory
     */
    public function sendContactMessage(ContactMessageRequest $request): Response|ResponseFactory
    {
        $payload = $this->handleApi->handlePayload(
            ContactMessageRequest::class,
            $this->modelContactMessage->getFillable()
        );

        $query = $this->modelContactMessage->createRecord($payload);
        unset($query['user_id']);

        if ($query) {
            $emailPayload = $query->toArray();
            Mail::to($emailPayload['email'])->send(new ConfirmContactMessage($emailPayload));
        }

        return $this->handleApi->handleApiResponse(
            $query,
            ContactMessage::class
        );
    }

    /**
     * Get all active newsletter campaigns in the current month.
     *
     * @return Response|ResponseFactory
     */
    public function getNewsletterCampaigns(): Response|ResponseFactory
    {
        $query = $this->modelNewsletterCampaign->fetchClientCampaigns();

        return $this->handleApi->handleApiResponse($query);
    }

    /**
     * Newsletter subscribe.
     *
     * @param NewsletterSubscriberRequest $request
     * @return Response|ResponseFactory
     */
    public function newsletterSubscribe(NewsletterSubscriberRequest $request): Response|ResponseFactory
    {
        $payload = $this->handleApi->handlePayload(
            NewsletterSubscriberRequest::class,
            $this->modelNewsletterSubscriber->getFillable()
        );
        $payload['valid_email'] = 1;

        foreach ($payload['newsletter_campaign_id'] as $id) {
            $payload['newsletter_campaign_id'] = $id;
            $this->modelNewsletterSubscriber->createRecord($payload);
        }
        $search = [
            'email' => $payload['email'],
            'newsletterCampaignIds' => $payload['newsletter_campaign_id'],
        ];
        $query = $this->modelNewsletterSubscriber->fetchAllRecords($search);

        return $this->handleApi->handleApiResponse(
            $query,
            NewsletterSubscriber::class
        );
    }

    /**
     * Newsletter unsubscribe.
     *
     * @param string $email
     * @param string $newsletterCampaignIds
     * @return Response|ResponseFactory
     */
    public function newsletterUnsubscribe(string $email, string $newsletterCampaignIds): Response|ResponseFactory
    {
        $subscriberCampaignIds = json_decode($newsletterCampaignIds, true);
        $search = [
            'email' => $email,
            'newsletterCampaignIds' => $subscriberCampaignIds,
        ];
        $query = $this->modelNewsletterSubscriber->fetchAllRecords($search);

        if ($query instanceof Collection) {
            if ($query->isNotEmpty()) {
                foreach ($query->pluck('id')->toArray() as $id) {
                    $this->modelNewsletterSubscriber->deleteRecord($id);
                }
            }
            return $this->handleApi->handleApiResponse(
                [],
                NewsletterSubscriber::class
            );
        } else {
            return $this->handleApi->handleApiResponse($query);
        }
    }

    /**
     * Services review
     *
     * @param ReviewRequest $request
     * @return Response|ResponseFactory
     */
    public function sendReview(ReviewRequest $request): Response|ResponseFactory
    {
        $payload = $this->handleApi->handlePayload(
            ReviewRequest::class,
            $this->modelReview->getFillable()
        );
        $payload['is_active'] = false;

        $query = $this->modelReview->createRecord($payload);
        unset($query['user_id']);

        return $this->handleApi->handleApiResponse(
            $query,
            ContactMessage::class
        );
    }
}
