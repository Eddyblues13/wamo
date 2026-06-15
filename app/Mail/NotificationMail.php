<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, string>  $lines
     * @param  array<string, string>  $details
     */
    public function __construct(
        public string $subjectLine,
        public string $heading,
        public string $greetingName,
        public array $lines = [],
        public array $details = [],
        public ?string $note = null,
        public ?string $ctaText = null,
        public ?string $ctaUrl = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subjectLine);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.notification');
    }

    /**
     * Send a branded notification email without ever interrupting the
     * user's request if mail delivery fails.
     *
     * @param  array<int, string>  $lines
     * @param  array<string, string>  $details
     */
    public static function deliver(
        Authenticatable $user,
        string $subject,
        string $heading,
        array $lines = [],
        array $details = [],
        ?string $note = null,
        ?string $ctaText = null,
        ?string $ctaUrl = null,
    ): void {
        try {
            Mail::to($user)->send(new self(
                $subject,
                $heading,
                $user->name ?? 'there',
                $lines,
                $details,
                $note,
                $ctaText,
                $ctaUrl,
            ));
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
