<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\MGateAuthorization;

class GateAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /*
           ex) http://127.0.0.1:8000/mypage/?id=1&q=44

        print $request->root();//http://127.0.0.1:8000
        print " | ";
        print $request->url();//http://127.0.0.1:8000/mypage
        print " | ";
        print $request->fullUrl();//http://127.0.0.1:8000/mypage?id=1&q=44
        // print $request->fullUrlWithQuery();//http://127.0.0.1:8000/mypage
        print " | ";
        print $request->path();//mypage
        print " | ";
        // print $request->route();//ルートクラスが返ってくる　https://laravel.com/api/9.x/Illuminate/Routing/Route.html
        print " | ";
        print (int)$request->routeIs(['mypae','supporter-page']); //1 or 0
        print " | ";
        print $request->user()->name;//斉藤雅子
        */

        //パス情報から、許可されているGATE情報を取得する
        $mga=MGateAuthorization::find($request->path());
        
        if(!is_null($mga)){
            //GATE情報はカンマ区切りで入ってくるので、配列に変換する
            $gates = explode(',',$mga->AuthorizedGate);

            foreach($gates as $gate){
                print $gate;
                print " | ";
                if(Gate::allows($gate)){
                    //一度でも許可されれば、その時点で通過
                    return $next($request);
                }

            }
        }
        //一度も許可されずここまでくれば、権限無しエラー
        abort(403);
    }
}
