<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

use App\Models\Hogosha;
use App\Models\Student;
use App\Models\Absence as AbModel;


class AbsenceHogosha extends Component
{

    use WithPagination;

    //未振替テーブル用
    public $orderColumn = "AbsentDate";
    public $sortOrder = "asc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    //振替済みテーブル用
    public $orderColumnDone = "AbsentDate";
    public $sortOrderDone = "desc";
    public $sortLinkDone = '<i class="sorticon fa-solid fa-caret-down"></i>';

    //選択中のスチューデントコード
    public $selectedSCd = "DUMMY";
    //ラジオボタンの値
    public $rdHurikae = "rdUn";
    //それぞれの件数
    public $countUn = 0;
    public $countDone = 0;

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
        ->whereIn('HurikaeStatus',[0,9])
        ->orderby($this->orderColumn,$this->sortOrder)
        ->paginate(8);

        //ヘッダ表示表に総件数を取得
        $this->countUn = $items_un->total();

        //振替済み欠席情報の取得
        $items_done = AbModel::with('student')
        ->where('StudentCd',$studentCd)
        ->whereNotIn('HurikaeStatus',[0,9])
        ->orderby($this->orderColumnDone,$this->sortOrderDone)
        ->paginate(5,['*'],'pageDone');
        //1ページに複数のpaginationをする場合は、このように名前を指定する。URLの ~? pageDone=2を指定している。 

        //ヘッダ表示表に総件数を取得
        $this->countDone = $items_done->total();


        $args=[
            'students' => $this->students,
            'studentName' => $studentName,
            'absences_un' => $items_un,
            'absences_done' => $items_done,
        ];

        return view('livewire.absence-hogosha',$args);
    }
    // updated メソッドは、Livewireコンポーネント内の特別なメソッドであり、プロパティが更新されたときに自動的に呼び出されます。
    public function updated(){
        //paginationを使用するときに、ページネーションをリセットして最初のページに戻すために使用されます。
        //何かが変更されたときにページをリセットし、最初のページに戻すことができます。
        $this->resetPage();
        $this->resetPage('pageDone');
    }
    //selectedSCdプロパティが変更されたときに発生するイベント（勝手にコールされる）
    public function updatedSelectedSCd(){

        //選択された生徒コードが変わった時、
        //ページネーションをリセットする
        $this->resetPage();
        $this->resetPage('pageDone');

    }
    //未振替テーブル用
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
    //振替済みテーブル用
    public function sortOrderDone($columnName=""){
        $caretOrder = "up";
        //今がASCならDESC。DESCならASC
        if($this->sortOrderDone == 'asc'){
             $this->sortOrderDone = 'desc';
             $caretOrder = "down";
        }else{
             $this->sortOrderDone = 'asc';
             $caretOrder = "up";
        } 
        $this->sortLinkDone = '<i class="sorticon fa-solid fa-caret-'.$caretOrder.'"></i>';

        $this->orderColumnDone = $columnName;

    }

}
