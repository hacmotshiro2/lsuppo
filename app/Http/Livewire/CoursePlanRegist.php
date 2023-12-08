<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\Models\Student;
use App\Models\Supporter;
use App\Models\MKoumoku;
use App\Models\CoursePlan;


class CoursePlanRegist extends Component
{
    use WithPagination;

    public $orderColumn = "ApplicationDate";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';

    //選択中のスチューデントコード
    public $selectedSCd = "DUMMY";

    public function __construct()
    {
        //ページロード時のみ呼べばいい

        //選択できる生徒やプラン・コースの一覧をつくる(Livewire変数にしたくないのでここで宣言、セットする)
        $this->students = Student::all();
    }
    public function render()
    {

        $courseplans = CoursePlan::where('StudentCd',$this->selectedSCd)->orderby($this->orderColumn,$this->sortOrder)->paginate(5);

        $courses = DB::table('m_koumoku')->where('Shubetu',110)->get();
        $plans = DB::table('m_koumoku')->where('Shubetu',120)->get();

        $args=[
            'students' => $this->students,
            'courses' => $courses,
            'plans' => $plans,
            'courseplans' => $courseplans,
        ];

        return view('livewire.courseplan-regist',$args);
    }
}
