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

// class UserRegisteredNotification extends Notification
class UserRegisteredNotification extends LSuppoNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $url = url('/');

        return (new MailMessage)
                    ->subject(env('MAIL_SUBJECT_PRE').'登録頂きありがとうございました。')
                    ->greeting('こんにちは　プログラミングスクールLです。')
                    ->line('エルサポでユーザーの登録が完了しました。')
                    ->line('この後、管理者による確認作業が必要です。お待ちください。')
                    ->line('準備が整いましたら、改めてご案内致します。')
                    ->line('')
                    ->line('いつもありがとうございます。');
    }

    public function toLine($notifiable)
    {
        $url= url('/');

        return (new TextMessageBuilder("登録頂きありがとうございました。
        \nこんにちは　プログラミングスクールLです。
        \nエルサポでユーザーの登録が完了しました。
        \nこの後、管理者による確認作業が必要です。お待ちください。
        \n準備が整いましたら、改めてご案内致します。
        "
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
