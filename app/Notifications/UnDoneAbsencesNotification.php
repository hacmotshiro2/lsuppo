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

use App\Models\Student;

class UnDoneAbsencesNotification extends LSuppoNotification
{
    use Queueable;

    private bool $toHogosha; //保護者かどうか。falseならサポーター向け
    private string $name; //通知先のお名前
    private $students;
    private $countPerStudent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($isToHogosha = false, $name, $students, $countPerStudent)
    {
        $this->toHogosha = $isToHogosha;
        $this->name = $name;
        $this->students = $students;
        $this->countPerStudent=$countPerStudent;
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
        $today = now()->format('Y年n月j日');
        $ret = new MailMessage();

        if($this->toHogosha){
            //保護者向けの場合
            $ret = $ret
            ->subject(env('MAIL_SUBJECT_PRE').'未振替の欠席情報をお知らせします')
            ->greeting($this->name.'さん こんにちは　プログラミングスクールLです。')
            ->line('')
            ->line($today.'時点の未振替件数をお知らせします。');
        }
        else{
            //サポーター向け（管理者向け）の場合
            //序文
            $ret = $ret
            ->subject(env('MAIL_SUBJECT_PRE').'未振替の欠席情報の一覧をお知らせします')
            ->greeting($this->name.'さん こんにちは　プログラミングスクールLです。')
            ->line('')
            ->line($today.'時点の未振替件数の一覧をお知らせします。');
        }
        //中身
        foreach($this->countPerStudent as $key => $count){
            // $keyには連想配列のキーが格納されています
            // $countには連想配列の値が格納されています

            // 呼び出し側で、対象の生徒に絞っている前提

            // 例）SDemo2 斉藤向日葵 2 件
            $student = $this->students->where('StudentCd',$key)->first();
            $ret = $ret->line($student->StudentCd." ".$student->HyouziMei."さん ".$count." 件");
        }

        return $ret;
        
    }

    //
    public function toLine($notifiable)
    {
        $today = now()->format('Y年n月j日');
        $content = "";

        //保護者向け・サポーター向け（管理者向け）に差なし

        foreach($this->countPerStudent as $key => $count){
            // $keyには連想配列のキーが格納されています
            // $balanceには連想配列の値が格納されています

            // 呼び出し側で、対象の生徒に絞っている前提

            // 例）SDemo2 斉藤向日葵 405 エルコイン
            $student = $this->students->where('StudentCd',$key)->first();
            $content = $content.$student->StudentCd." ".$student->HyouziMei."さん ".$count." 件 \n";
        }

        return (new TextMessageBuilder($this->name."さん こんにちは　プログラミングスクールLです。\n"
        .$today."時点の未振替件数をお知らせします。\n\n"
        .$content));
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
