<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

use LINE\LINEBot;
use LINE\LINEBot\Response;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;

class LineChannel
{

    // LINE API Client
    private $bot;

    public function __construct(){

        //チャネルアクセストークンをセット
        $httpClient = new CurlHTTPClient(env('LINE_CHANEL_A_TOKEN'));
        //チャネルシークレットをセット
        $this->bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_CHANEL_SECRET')]);
    }

    //送信の実処理
    public function send($notifiable, Notification $notification)
    {
        // Log::info("line通知",[$notifiable->routeNotificationFor('line')]);

        // notifiable(つまりuser)がline通知に対応しているかをチェック（Userモデル側で）
        if (! $channel = $notifiable->routeNotificationFor('line')) {
            return;
        }

        $user_id = $notifiable->line_user_id;
        $messageBuilder = $notification->toLine($notifiable);

        //pushメッセージの送信
        //第一引数は宛先のUserId
        $response = $this->bot->pushMessage($user_id, $messageBuilder);

        Log::info("linePush結果",[$response->getRawBody()]);

        return;

    }

    //友だち追加されているかどうかをチェックする
    public function checkIsFriend($notifiable){

        //line_user_idを紐づけ済みかどうかチェック
        $user_id = $notifiable->line_user_id;
        if(empty($user_id)){
            return false;
        }

        //エルサポ公式アカウントを友だち追加で来ているかチェック
        $response = $this->bot->getProfile($user_id);
        if($response->isSucceeded()){
            //成功
            return true;
        }
        return false;
    }

}