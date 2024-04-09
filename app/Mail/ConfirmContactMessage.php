<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public array $emailPayload;

    /**
     * Create a new message instance.
     */
    public function __construct(array $payload)
    {
        $this->emailPayload = $payload;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('app.email'),
            to: $this->emailPayload['email'],
            subject: 'Confirm contact message ' . $this->emailPayload['contact_subject']['label'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirm-contact-message',
            with: [
                'payload' => $this->emailPayload
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
