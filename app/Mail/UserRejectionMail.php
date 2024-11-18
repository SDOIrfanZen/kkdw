<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $remark;

    public function __construct($user, $remark)
    {
        $this->user = $user;
        $this->remark = $remark;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Akaun Anda Telah Ditolak',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account_rejected',
            with: [
                'user' => $this->user,  // Pass the user data to the email view
                'remark' => $this->remark,  // Pass the rejection remark to the email view
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
