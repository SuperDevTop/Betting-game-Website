<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCreatedUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pwd;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $pwd)
    {
        $this->user = $user;
        $this->pwd  = $pwd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admincreated-user')
            ->with(['user' => $this->user, 'code' => $this->pwd]);
    }
}
