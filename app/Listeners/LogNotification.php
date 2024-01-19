<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;

use App\Models\NotificationLog as NL;

class LogNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Notifications\Events\NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        //ログ履歴テーブルに更新する
        $nl = new NL;
        $nl->user_id = $event->notifiable->id;
        $nl->name = $event->notifiable->name;
        $nl->email = $event->notifiable->email;
        $nl->line_user_id = $event->notifiable->line_user_id;
        $nl->notification_type = $event->notifiable->notification_type;
        $nl->notification_class = $event->notification::class;
        $nl->channel = $event->channel;

        $nl->save();

        // Log::info('[NotificationSent]',[$event->notifiable,$event->notification,$event->channel,$event->response]);
    }
}
