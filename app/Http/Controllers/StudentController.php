<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\LR;

use App\Consts\MessageConst;

class StudentController extends Controller
{
    //

    /*システム管理者が使用する画面*/
    //生徒登録画面へ
    public function add(Request $request){
        $items = Student::all();
        $lrs = LR::all();

        $arg=[
            'items'=>$items,
            'lrs' =>$lrs,
            'userName'=>'システム管理者',
        ];

        return view('student.add',$arg);

    }
}
