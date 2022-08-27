<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Notifications\Messages\MailMessage;


class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        //
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
     
        $url = url('/');

        return $this->to(env('MAIL_TO_SYSAD'))
        ->subject(env('MAIL_SUBJECT_PRE').'新規ユーザーが登録されました。')
        ->view('mail.userRegistered')
        ->with(['name'=>$this->name]);
    }
}
