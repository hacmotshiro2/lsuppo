<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LCoinAddedNotification extends Notification
{
    use Queueable;

    private string $name;
    private string $amount;
    private string $ziyuu;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $name,string $amount,string $ziyuu)
    {
        //
        $this->name = $name;
        $this->amount = $amount;
        $this->ziyuu = $ziyuu;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url= url('/lc/');

        return (new MailMessage)
        ->subject(env('MAIL_SUBJECT_PRE').'エルコインが付与されました')
        ->greeting($this->name.'さん こんにちは　プログラミングスクールLです。')
        ->line('以下の通りエルコインが付与されましたので、お知らせいたします。')
        ->line('')
        ->line('** エルコイン **')
        ->line('付与数量：　'.$this->amount)
        ->line('事由：　'.$this->ziyuu)
        ->line('')
        ->action('詳しくはこちらから',$url)
        ->line('');
            
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
