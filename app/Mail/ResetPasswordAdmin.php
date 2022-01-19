<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public  $reset;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reset)
    {
        $this->reset = $reset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->subject(config('app.name') . ' - Reset Password')
                ->view('common.mails.reset_password_admin', ['reset'=>$this->reset]);
    }
}
