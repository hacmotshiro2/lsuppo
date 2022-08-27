<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\User;


class User2HogoshaRegisteredNotification extends Notification
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
        $this->name = $name;
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
        $url= url('/mypage');

        return (new MailMessage)
        ->subject(env('MAIL_SUBJECT_PRE').'ご利用いただける準備が整いました。')
        ->greeting($this->name.'さん こんにちは　プログラミングスクールLです。')
        ->line('登録いただいた内容の確認を行い、お子様との紐づけ作業が完了しました。')
        ->line('ご利用いただく準備が全て整いました。')
        ->line('')
        ->action('こちらから',$url)
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
