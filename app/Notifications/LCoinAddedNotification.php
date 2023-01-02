<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Notifications\LSuppoNotification;

use Illuminate\Support\Facades\Log;

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

class LCoinAddedNotification extends LSuppoNotification
// class LCoinAddedNotification extends Notification
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

    public function toLine($notifiable)
    {
        $url= url('/lc/');

        return (new TextMessageBuilder("エルコインが付与されました
        \n".$this->name."さん こんにちは　プログラミングスクールLです。
        \n以下の通りエルコインが付与されましたので、お知らせいたします。
        \n
        \n** エルコイン **
        \n付与数量： ".$this->amount.
        "\n事由： ".$this->ziyuu.
        "\n\n詳しくはこちらから\n".
        $url."\n"
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
}
