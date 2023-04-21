<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;


class UserResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $userToken;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, UserToken $userToken)
    {
        $this->user = $user;
        $this->userToken = $userToken;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            from: new Address('admin@test.com', '管理者'),
            subject: 'パスワードをリセットする',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $tokenParam = ['reset_token' => $this->userToken->token];
        $now = Carbon::now();

        // 48時間後を期限とした署名付きURLを生成
        $url = URL::temporarySignedRoute('password_reset.edit', $now->addHours(48), $tokenParam);

        return new Content(
            view: 'mails.password_reset_mail',
            with: [
                'user' => $this->user,
                'url' => $url,
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
