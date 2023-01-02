<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Notifications\LSuppoNotification;

class FBApprovedNotification extends LSuppoNotification
// class FBApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private string $name;

    public function __construct($name)
    {
        //
        $this->name=$name;
    }

    // /**
    //  * Get the notification's delivery channels.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function via($notifiable)
    // {
    //     return ['mail'];
    // }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url= route('fbIndex');

        return (new MailMessage)
        ->subject(env('MAIL_SUBJECT_PRE').'新しいフィードバックが届きました')
        ->greeting($this->name.'さん こんにちは　プログラミングスクールLです。')
        ->line('サポーターから新しいフィードバックが届きました。')
        ->line('')
        ->line('下記ボタンからご覧ください')
        ->action('こちらから',$url)
        ->line('');
    }

    public function toLine($notifiable){

        $url= route('fbIndex');

        return (new TextMessageBuilder("新しいフィードバックが届きました。\n"
        .$this->name."さん こんにちは　プログラミングスクールLです。\n
        サポーターから新しいフィードバックが届きました。\n
        \n
        下記リンクからご覧ください。
        こちら\n"
        .$url."\n"));
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
