<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ControlSettings
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

        #TODO 保護者かサポーターかで、遷移先を分岐したい
        /*
        と思っていたが、
        usersのみを設定する画面という切り分けにするなら、このミドルウェアは要らない
        */
        return $next($request);
    }
}
