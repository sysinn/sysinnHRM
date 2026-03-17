<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The user's email.
     *
     * @var string
     */
    public $email;

    /**
     * The application name.
     *
     * @var string
     */
    public $appName;

    /**
     * The reset URL.
     *
     * @var string
     */
    public $resetUrl;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param string $token
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->appName = config('app.name', 'SysSin HRM');
        
        // Build the reset URL
        $this->resetUrl = config('app.url', 'http://localhost') . '/reset-password/' . $token . '?email=' . urlencode($email);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Password - SysSin HRM',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset',
            with: [
                'appName' => $this->appName,
                'resetUrl' => $this->resetUrl,
                'email' => $this->email,
                'token' => $this->token,
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
