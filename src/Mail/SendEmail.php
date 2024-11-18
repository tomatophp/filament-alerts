<?php

namespace TomatoPHP\FilamentAlerts\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public string $content,
        public ?string $title = null,
        public ?string $url = null
    ) {
        $this->title = $title ?? 'New Notification From ' . config('app.name');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: config('filament-alerts.email.template') ?? 'filament-alerts::email.template',
            with: ['content' => $this->content, 'url' => $this->url],
        );
    }
}
