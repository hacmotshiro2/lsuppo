<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MVPresentation;

class MVController extends Controller
{
    //
    public function index(Request $request){
        //TODO 閲覧制限　絞り込み
        $items = MVPresentation::all();
        $args=[
            'items'=>$items,
        ];
        return view('mv.mvPresenWatch',$args);

    }
}
