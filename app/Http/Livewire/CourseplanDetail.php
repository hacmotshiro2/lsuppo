<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon; // Carbonクラスを使うために追加

use App\Models\Hogosha;
use App\Models\Student;
use App\Models\CoursePlan;
use App\Models\MMonthlyFee;

class CourseplanDetail extends Component
{
    use WithPagination;

    //選択中のスチューデントコード
    public $selectedSCd = "DUMMY";

    public function __construct()
    {
        //ページロード時のみ呼べばいい（保護者は変わらないので）

        //認証情報を取得し、保護者コードを取得する
        $user = Auth::user();
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        //保護者が選択できる生徒の一覧をつくる(Livewire変数にしたくないのでここで宣言、セットする)
        $this->students = Student::where('hogoshaCd',$hogoshaCd)->orderBy('StudentCd','asc')->get();

        //一番最初のStudentCdを選択
        if(count($this->students)>0){
            $this->selectedSCd = $this->students->first()->StudentCd;
        }
    }

    public function render()
    {
        //取得する情報がない場合1を立てる
        $noitem=0;

        //選択中の（抽出対象の）生徒コード　未選択なら空白に
        $studentCd = isset($this->selectedSCd) ? $this->selectedSCd : "";

        //選択中の生徒コードから生徒名を取得　未選択なら空白に
        $student = Student::find($this->selectedSCd);
        $studentName = $student ? $student->HyouziMei : "";

        // Log::info("CourseplanDetailLivewire",[$studentCd,$studentName]);

        //コースプラン履歴を取得
        //student という名前のリレーションシップを eager loading 
        $cpHistories=[];
        $cpHistories = CoursePlan::with('student')
        ->where('StudentCd',$this->selectedSCd)
        ->where('ApplicationDate',"<=",Carbon::now())
        ->orderby('ApplicationDate','desc')
        ->get();

        //コースプラン月謝マスタの取得
        $mmfs= MMonthlyFee::orderby('CPCd','ASC')
        ->get();

        // 選択中のコースプランを1行目、それ以外を2行目以降にした配列を作る
        $cps=new Collection();

        if($cpHistories->isNotEmpty()){

            //条件に合致する行を先頭に配置する
            $cps = $mmfs->sortByDesc(function ($item) use ($cpHistories) {
                return $item['CPCd'] == MMonthlyFee::getCPCd($cpHistories[0]->CourseCd,$cpHistories[0]->PlanCd);
            })->values();//☆☆☆values()をつけないと、キー（インデックス）はそのまま。
        }
        else{
            $noitem = 1;
        }

        $args=[
            'students' => $this->students,
            'studentName' => $studentName,
            'cps' => $cps,
            'cpHistories' => $cpHistories,
            'noitem'=>$noitem,
        ];

        // echo '<pre>';
        // print_r("| ");
        // print_r($cps[0]->CPCd);
        // print_r(",");
        // print_r($cps[0]->Fee);

        // print_r("  --- cps --- ");
        // foreach ($cps as $cp) {
        //     print_r("| ");
        //     print_r($cp->index);
        //     print_r($cp->CPCd);
        //     print_r(",");
        //     print_r($cp->Fee);
        // }
        // print_r("  --- cpHistories --- ");
        // foreach ($cpHistories as $cpHistory) {
        //     print_r("| ");
        //     print_r($cpHistory->CourseCd);
        //     print_r(",");
        //     print_r($cpHistory->PlanCd);
        // }
        // echo '</pre>';
        // echo '<pre>';
        // var_dump($cps);
        // // var_dump($cpHistories);
        // echo '</pre>';

        return view('livewire.courseplan-detail',$args);
    }
    // updated メソッドは、Livewireコンポーネント内の特別なメソッドであり、プロパティが更新されたときに自動的に呼び出されます。
    public function updated($field)
    {
        // Log::info("updated",[$field]);

        if ($field == 'selectedSCd') {
            $this->render();
        }
    }
    
    //selectedSCdプロパティが変更されたときに発生するイベント（勝手にコールされる）
    public function updatedSelectedSCd()
    {
        // Log::info("updatedSelectedSCd",["updatedSelectedSCd"]);
        $this->render();
    }


}
