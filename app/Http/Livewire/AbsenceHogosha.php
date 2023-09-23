<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Hogosha;
use App\Models\Student;
use App\Models\Absence as AbModel;


class AbsenceHogosha extends Component
{

    //ページロード時の設定
    public $orderColumn = "AbsentDate";
    public $sortOrder = "asc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $selectedSCd = "DUMMY";
    public $rdHurikae = "rdUn";

    public function __construct()
    {
        //ページロード時のみ呼べばいい（保護者は変わらないので）

        //認証情報を取得し、保護者コードを取得する
        $user = Auth::user();
        $hogoshaCd = Hogosha::getHogoshaCd($user);
        //保護者が選択できる生徒の一覧をつくる
        $this->students = Student::where('hogoshaCd',$hogoshaCd)->orderBy('StudentCd','asc')->get();

        //一番最初のStudentCdを選択
        $this->selectedSCd = $this->students->first()->StudentCd;

    }

    public function render()
    {

        //選択中の（抽出対象の）生徒コード　未選択なら空白に
        $studentCd = isset($this->selectedSCd) ? $this->selectedSCd : "";

        //選択中の生徒コードから生徒名を取得　未選択なら空白に
        $student = Student::find($studentCd);
        $studentName = $student ? $student->HyouziMei : "";

        // Log::info("欠席情報Livewire",[$studentCd,$studentName]);

        //未振替欠席情報の取得（期限切れもこちらに）
        //student という名前のリレーションシップを eager loading 
        $items_un = AbModel::with('student')
        ->where('StudentCd',$studentCd)
        ->where('HurikaeStatus',0)
        ->orderby($this->orderColumn,$this->sortOrder)
        ->paginate(10);

        //振替済み欠席情報の取得
        $items_done = AbModel::with('student')
        ->where('StudentCd',$studentCd)
        ->whereNot('HurikaeStatus',0)
        ->orderby($this->orderColumn,$this->sortOrder)
        ->paginate(10);



        $args=[
            'students' => $this->students,
            'studentName' => $studentName,
            'absences_un' => $items_un,
            'absences_done' => $items_done,
        ];

        return view('livewire.absence-hogosha',$args);
    }

    public function sortOrder($columnName=""){
        $caretOrder = "up";
        //今がASCならDESC。DESCならASC
        if($this->sortOrder == 'asc'){
             $this->sortOrder = 'desc';
             $caretOrder = "down";
        }else{
             $this->sortOrder = 'asc';
             $caretOrder = "up";
        } 
        $this->sortLink = '<i class="sorticon fa-solid fa-caret-'.$caretOrder.'"></i>';

        $this->orderColumn = $columnName;

    }
}
