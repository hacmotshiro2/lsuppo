<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Notifications\LSuppoNotification;

use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

// class User2SupporterRegisteredNotification extends Notification
class User2SupporterRegisteredNotification extends LSuppoNotification
{
    use Queueable;

    private string $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        //
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
        $url= url('/');

        return (new MailMessage)
        ->subject(env('MAIL_SUBJECT_PRE').'ご利用いただける準備が整いました。')
        ->greeting($this->name.'さん こんにちは　プログラミングスクールLです。')
        ->line('登録いただいた内容の確認を行い、サポーターとしての準備作業が完了しました。')
        ->line('ご利用いただく準備が全て整いました。')
        ->line('')
        ->action('こちらから',$url)
        ->line('');
    }

    public function toLine($notifiable)
    {
        $url= url('/');

        return (new TextMessageBuilder("ご利用いただける準備が整いました。
        \n".$this->name."さん こんにちは　プログラミングスクールLです。
        \n登録いただいた内容の確認を行い、サポーターとしての準備作業が完了しました。
        \nご利用いただく準備が全て整いました。
        \n
        \nこちらから"
        .$url."\n"
        ));
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

    //Override
    public function shouldSend($notifiable, $channel)
    {
        // この通知は必ず送る
        return true;
    }
}
