<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Notifications\Channels\LineChannel;

abstract class LSuppoNotification extends Notification
{
    use Queueable;

    // ref:https://github.com/laravel-notification-channels/discord/blob/master/src/DiscordChannel.php
   
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable Userの中にあるtrait
     * @return array
     */
    public function via($notifiable)
    {
        //友だち追加されていて、設定情報の通知先がLineになっていたらlineを指定。
        if((new LineChannel())->checkIsFriend($notifiable) and $notifiable->notification_type==1){
                return ['line'];
        }

        return ['mail'];
    }
    /**  
    * MessageBuilderを返す必要がある。
    * 返したMessageBuilderは、LineChannelクラスでpushされる
    * 
    * 参考）
    * driver名 line に対して、toLineは、UpperCamel型にする必要がある
    */
    protected abstract function toLine($notifiable);
}

