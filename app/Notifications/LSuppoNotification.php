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
     * @param  mixed  $notifiable Userの中にあるtrait つまり$userのインスタンスが入ってくる
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

    // No.Ph.2.4 h.hashimoto 2024/01/19 ------>
    // 利用終了している保護者やサポーターには通知しない
    /**
     * Determine if the notification should be sent.
     *
     * @param  mixed  $notifiable
     * @param  string  $channel
     * @return bool
     */
    public function shouldSend($notifiable, $channel)
    {
        //UserのisDisabledが1なら送らない
        if($notifiable->isDisabled == 1){return false;}

        return true;
    }
    // <------  No.Ph.2.4 h.hashimoto 2024/01/19 

}

