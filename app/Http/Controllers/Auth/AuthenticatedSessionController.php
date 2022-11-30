<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// No. h.hashimoto 2022/11/30 ------>
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use App\Models\SigninHistory;
// <------  No. h.hashimoto 2022/11/30 

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * ログイン画面のPOST処理
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // No. h.hashimoto 2022/11/30 ------>
        // クライアント情報の取得
        $ip = $request->ip();
        $useragent = $request->header('User-Agent');
        $agent = new Agent();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $user = Auth::user();

        Log::info('サインインに成功しました',[$ip,$useragent,$device,$platform,$browser,$user->id]);

        // エルサポログイン履歴テーブルへの更新
        $sh = new SigninHistory();
        $sh->user_id = $user->id;
        $sh->signin_datetime = date("Y/m/d H:i:s");
        $sh->ip = $ip;
        $sh->user_agent = substr($useragent,0,128);
        $sh->os = $platform;
        $sh->device = $device;
        $sh->browser = $browser;

        $sh->save();
        // <------  No. h.hashimoto 2022/11/30 

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
