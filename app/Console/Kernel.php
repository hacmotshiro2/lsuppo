<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DateTimeZone;

use App\Console\Commands\MonitorLCoinBalance;
use App\Console\Commands\MonitorLUnDoneAbsences;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        //エルコイン残高のチェック（保護者向け、管理者向け）毎月20日朝9時
        $schedule->command(MonitorLCoinBalance::class, [null,null])->monthlyOn(20, '09:00');
        // $schedule->command(MonitorLCoinBalance::class, [null,null])->everyMinute();

        //未振替欠席情報のチェック（保護者向け、管理者向け）毎月5日と20日朝9時
        $schedule->command(MonitorLUnDoneAbsences::class, [null,null])->twiceMonthly(5, 20, '09:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * スケジュールされたイベントで使用するデフォルトのタイムゾーン取得
     */
    protected function scheduleTimezone(): DateTimeZone|string|null
    {
        return 'Asia/Tokyo';
    }
}
