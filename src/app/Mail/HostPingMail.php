<?php

namespace Romkamix\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Romkamix\App\Models\HostPing;

class HostPingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ping = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(HostPing $ping)
    {
        $this->ping = $ping;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $host = $this->ping->host;

        return new Envelope(
            subject: sprintf(
                "%s is %s",
                $host->name,
                $this->ping->latency ? 'up' : 'down'
            ),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $host = $this->ping->host;

        return new Content(
            markdown: 'romkamix::mails.host.ping',
            with: [
                'name' => $host->name,
                'pings' => $host
                    ->pings()
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->get()
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
