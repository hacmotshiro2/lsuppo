<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\LR;
use App\Models\Student;
use App\Models\Supporter;


class SysAdController extends Controller
{
    //
    public function index(Request $request, Response $response){
        
        return view('SysAdmin.index');
    }

   

}
