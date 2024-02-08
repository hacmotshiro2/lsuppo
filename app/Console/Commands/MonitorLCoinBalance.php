<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Hogosha;
use App\Models\LCoinMeisai;
use App\Models\Student;
use App\Models\User;
use App\Models\User2Hogosha;

use App\Consts\AuthConst;

use App\Notifications\LCoinBalanceNotification;


class MonitorLCoinBalance extends Command
{
    /**
     * $signature：artisanコマンドとして実行するコマンド名。
     * $description：コマンドの説明。
     * construct：クラスが作られるときに処理される内容。handleメソッドの前に行いたい処理があれば記述する。
     * handle：実際の処理を記述する。
     * https://qiita.com/hinako_n/items/fc10ad4ae4c16a06bce0
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monitorlcbalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'エルコイン残高をチェックし、保護者・管理者に通知するコマンド';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('handle',['MonitorLCoinBalanceがhandleされました']);

        $today = now()->toDateString();
        $balancePerStudent=[];

        // //1.アクティブなStudentを取得する
        // $students = Student::whereNull('RiyouShuuryouDate')
        // ->orWhere('RiyouShuuryouDate', '>', $today)
        // ->orderBy('StudentCd','asc')
        // ->get();
        //ゆくゆくは、アクティブだけに絞るが、ページ側と合わないので、一旦は全生徒にする
        $students = Student::orderBy('StudentCd','asc')
        ->get();

        Log::info('[MonitorLCoinBalance]1.students',[$students]);

        //2.Studentごとの残高を取得する 0コインはスキップ
        foreach($students as $student){
            // $balancePerStudent[$student->StudentCd] = LCoinMeisai::getLCoinZandakaByStudentCd($student->StudentCd);
            $balance = LCoinMeisai::getLCoinZandakaByStudentCd($student->StudentCd);
            if($balance <> 0){
                $balancePerStudent[$student->StudentCd] = $balance;
            }
        }

        Log::info('[MonitorLCoinBalance]2.balancePerStudent',[$balancePerStudent]);

        //3.sp_authlevel-9レベルの管理者向けに通知する
        //3-1.Userのうちサポーターを取得
        $sUsers = User::where('userType',AuthConst::USER_TYPE_SUPPORTER)->get();

        Log::info('[MonitorLCoinBalance]3-1.sUsers',[$sUsers]);

        foreach($sUsers as $sUser){
            //まずはこれでプロパティをセット
            $sUser->setUserTypeStatus();
            
            Log::info('[MonitorLCoinBalance]3-2sUser',[$sUser]);

            //3-2.レベル9以上の管理者であれば通知する
            if($sUser->sp_authlevel >= 9){

                $sUser->notify(new LCoinBalanceNotification(false,$sUser->name, $students, $balancePerStudent));

            }

        }

        //4.生徒の保護者に連絡する
        //4-1.Userのうちサポーターを取得
        $hUsers = User::where('userType',AuthConst::USER_TYPE_HOGOSHA)->get();

        Log::info('[MonitorLCoinBalance]4-1.hUsers',[$hUsers]);

        foreach($hUsers as $hUser){
            //まずはこれでプロパティをセット
            $hUser->setUserTypeStatus();
            
            Log::info('[MonitorLCoinBalance]4-2hUser',[$hUser]);

            //紐づきがまだのUserはスキップ
            if($hUser->isBinded==0){continue;}
            
            //4-3.認証情報から保護者コードを取得する
            $hogoshaCd = Hogosha::getHogoshaCd($hUser);

            Log::info('[MonitorLCoinBalance]4-3.hogoshaCd',[$hogoshaCd]);

            //4-4.保護者に紐づく生徒を取得
            //保護者コードからStudentを絞る
            // $hStudents = $student->where('HogoshaCd', $hogoshaCd)->get();//これだとなぜかうまくいかず。
            $hStudents = Student::where('HogoshaCd', $hogoshaCd)->get();

            Log::info('[MonitorLCoinBalance]4-4.hStudents',[$hStudents]);

            //残高も絞ってから渡す
            $hStudentCds = array_column($hStudents->toArray(),'StudentCd');
            $bps = array_intersect_key($balancePerStudent, array_flip($hStudentCds));

            //4-5.絞った生徒の情報で通知する
            $hUser->notify(new LCoinBalanceNotification(true,$hUser->name, $hStudents, $bps));

        }

        
        return 0;
    }
}
