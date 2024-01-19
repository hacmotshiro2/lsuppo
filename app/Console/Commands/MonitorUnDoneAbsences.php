<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Hogosha;
use App\Models\Absence as AbModel;
use App\Models\Student;
use App\Models\User;
use App\Models\User2Hogosha;

use App\Consts\AuthConst;

use App\Notifications\UnDoneAbsencesNotification;

class MonitorUnDoneAbsences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monitorundoneabsences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '未振替の欠席情報をチェックし、保護者・管理者に通知するコマンド';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('handle',['MonitorUnDoneAbsencesがhandleされました']);

        $today = now()->toDateString();
        $countPerStudent=[];

        // //1.アクティブなStudentを取得する
        // $students = Student::whereNull('RiyouShuuryouDate')
        // ->orWhere('RiyouShuuryouDate', '>', $today)
        // ->orderBy('StudentCd','asc')
        // ->get();
        //ゆくゆくは、アクティブだけに絞るが、ページ側と合わないので、一旦は全生徒にする
        $students = Student::orderBy('StudentCd','asc')
        ->get();

        Log::info('[MonitorUnDoneAbsences]1.students',[$students]);

        //2.Studentごとの未振替欠席情報を取得する
        foreach($students as $student){

            //未振替欠席情報の取得（期限切れもこちらに）
            //student という名前のリレーションシップを eager loading 
            $items_un = AbModel::with('student')
            ->where('StudentCd',$student->StudentCd)
            ->whereIn('HurikaeStatus',[0,9])
            ->get();

            //総件数を連想配列にセット
            $countPerStudent[$student->StudentCd] = $items_un->count();
        }

        Log::info('[MonitorUnDoneAbsences]2.countPerStudent',[$countPerStudent]);

        //3.sp_authlevel-9レベルの管理者向けに通知する
        //3-1.Userのうちサポーターを取得
        $sUsers = User::where('userType',AuthConst::USER_TYPE_SUPPORTER)->get();

        Log::info('[MonitorUnDoneAbsences]3-1.sUsers',[$sUsers]);

        foreach($sUsers as $sUser){
            //まずはこれでプロパティをセット
            $sUser->setUserTypeStatus();
            
            Log::info('[MonitorUnDoneAbsences]3-2sUser',[$sUser]);

            //3-2.レベル9以上の管理者であれば通知する
            if($sUser->sp_authlevel >= 9){

                $sUser->notify(new UnDoneAbsencesNotification(false,$sUser->name, $students, $countPerStudent));

            }

        }

        //4.生徒の保護者に連絡する
        //4-1.Userのうちサポーターを取得
        $hUsers = User::where('userType',AuthConst::USER_TYPE_HOGOSHA)->get();

        Log::info('[MonitorUnDoneAbsences]4-1.hUsers',[$hUsers]);

        foreach($hUsers as $hUser){
            //まずはこれでプロパティをセット
            $hUser->setUserTypeStatus();
            
            Log::info('[MonitorUnDoneAbsences]4-2hUser',[$hUser]);

            //紐づきがまだのUserはスキップ
            if($hUser->isBinded==0){continue;}
            
            //4-3.認証情報から保護者コードを取得する
            $hogoshaCd = Hogosha::getHogoshaCd($hUser);

            Log::info('[MonitorUnDoneAbsences]4-3.hogoshaCd',[$hogoshaCd]);


            //4-4.保護者に紐づく生徒を取得
            //保護者コードからStudentを絞る
            // $hStudents = $student->where('HogoshaCd', $hogoshaCd)->get();//これだとなぜかうまくいかず。
            $hStudents = Student::where('HogoshaCd', $hogoshaCd)->get();

            Log::info('[MonitorUnDoneAbsences]4-4.hStudents',[$hStudents]);

            //件数も絞ってから渡す
            $hStudentCds = array_column($hStudents->toArray(),'StudentCd');
            $cps = array_intersect_key($countPerStudent, array_flip($hStudentCds));

            //4-5.絞った生徒の情報で通知する
            if(count($cps)>0){
                $hUser->notify(new UnDoneAbsencesNotification(true,$hUser->name, $hStudents, $cps));
            }
        }

        
        return 0;
    }
}
