<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Providers\RouteServiceProvider;
use App\Consts\SessionConst;
use App\Consts\MessageConst;
use App\Models\User;


class LINELoginController extends Controller
{
    /**************************************************************************
    * LINEログイン 
    * https://developers.line.biz/ja/docs/line-login/integrate-line-login/ 
    * 
    ***************************************************************************/

    const CBURL_debug = "https://1931-2001-ce8-100-5b2b-a526-afcf-6e72-8379.jp.ngrok.io/api/line/callback/";

    /* キックする（トリガーとなる）画面3種類 */
    //GET
    public function lineLogin(Request $request){

        //stateの最初の1桁でどこから呼んだかを区分けする
        // A ログイン画面
        // B 設定画面
        // C ユーザ登録画面

        //stateをランダムに生成し、セッションに保持する（後ほど検証）
        $state='A'.self::makeRandStr(9);
        return $this->loginAuthorization($state);
    }
    //GET
    public function bind(Request $request){

        //stateの最初の1桁でどこから呼んだかを区分けする
        // A ログイン画面
        // B 設定画面
        // C ユーザ登録画面

        //stateをランダムに生成し、セッションに保持する（後ほど検証）
        $state='B'.self::makeRandStr(9);
        return $this->loginAuthorization($state);

    } 
    //GET
    public function createUser(Request $request){
        //stateの最初の1桁でどこから呼んだかを区分けする
        // A ログイン画面
        // B 設定画面
        // C ユーザ登録画面

        //stateをランダムに生成し、セッションに保持する（後ほど検証）
        $state='C'.self::makeRandStr(9);
        return $this->loginAuthorization($state);
        
    } 
    //LINE OAuthキック処理
    private function loginAuthorization(string $state){
        
        // セッションにセット
        session()->put(SessionConst::LINELOGIN_STATE,$state);

        //redirectURL
        $redirectURL = htmlentities(url('/api/line/callback/'),ENT_QUOTES,'UTF-8');
        if(env('APP_DEBUG')){
            //ngrok対策
            $redirectURL = htmlentities(self::CBURL_debug,ENT_QUOTES,'UTF-8');

        }

        $url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=".env('LINE_LOGIN_CHANEL_ID')."&redirect_uri=".$redirectURL."&state=".$state."&scope=profile%20openid";
        // $uri = "https://access.line.me/oauth2/v2.1/authorize?";
        // $param = [
        //     'response_type' =>'code',
        //     'client_id' =>env('LINE_LOGIN_CHANEL_ID'),
        //     'redirect_uri'=>$redirectURL,
        //     'state'=>$state,
        //     'scope'=>'profile%20openid'
        // ];
        // $url = $uri.http_build_query($param,"","&");
        // ↑ 必要以上にエンコードされて失敗

        return redirect($url);

    } 
    //②CallBackされる処理（LINE側からキックされる）
    public function callback(Request $request, Response $response ){
        

        //ログイン中にキャンセルなどの処理が行われた場合
        if($request->has('error')){

            return redirect()->intended(RouteServiceProvider::HOME);
        }
        
        //アクセストークンの取得に使用される認可コード。有効期間は10分です。また、認可コードは1回のみ利用可能です。
        $code = $request->code;
        //クロスサイトリクエストフォージェリ (opens new window)防止用の固有な英数字の文字列。この値が認可URLに付与したstateパラメータの値と一致することを検証してください。
        $state = $request->state;
        
        //セッションに保持したstateと一致するか確認する
        #TODO
        if($state != session()->get(SessionConst::LINELOGIN_STATE)){
            //例外処理
        }

        //1.アクセストークンを取得する
        // 取得URL
        $url = "https://api.line.me/oauth2/v2.1/token";
        //redirectURL
        $redirectURL = htmlentities(url('/api/line/callback/'),ENT_QUOTES,'UTF-8');
        if(env('APP_DEBUG')){
            //ngrok対策
            $redirectURL = htmlentities(self::CBURL_debug,ENT_QUOTES,'UTF-8');
        }
        // 渡すデータ
        $data =[
            'grant_type'=>'authorization_code',
            'code'=>$code,
            'redirect_uri'=>$redirectURL,
            'client_id'=>env('LINE_LOGIN_CHANEL_ID'),
            'client_secret'=>env('LINE_LOGIN_CHANEL_SECRET')
        ];
        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'POST',
                'header'=> 'Content-type: application/x-www-form-urlencoded', 
                'content'=> http_build_query($data,"","&"),
            )
        );

        // ストリームコンテキストの作成
        $context = stream_context_create($options);
        $raw_data = file_get_contents($url, false,$context);

        //取得できないとき、falseを返す。後続は処理せず、ここまでとする。
        if($raw_data==false){
            abort(500,MessageConst::LINE_ERROR);
            return;
        }
        // json の内容を連想配列として $data に格納する
        $item = json_decode($raw_data,true);

        
        //アクセストークン
        $access_token = $item['access_token'];
        //IDトークン
        $id_token = $item['id_token'];

        // 
        // 2.IDトークンからユーザー情報を取得する
        // 取得URL
        $url = "https://api.line.me/oauth2/v2.1/userinfo";
        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'GET',
                'header'=> 'Authorization: Bearer '.$access_token, //JSON形式で表示
            )
        );

        #TODO この辺の取得できなかったときエラーにならないように

        // ストリームコンテキストの作成
        $context = stream_context_create($options);
        $raw_data = file_get_contents($url, false,$context);

        //取得できないとき、falseを返す。後続は処理せず、ここまでとする。
        if($raw_data==false){
            abort(500,MessageConst::LINE_ERROR);
            return;
        }

        // json の内容を連想配列として $data に格納する
        $item = json_decode($raw_data,true);
        
        //取得したLINE user_idを格納
        $user_id = isset($item)?$item['sub']:"";


        // 予め渡しておいたstateの左一文字でどこの画面から呼ばれたかを判定する
        $val = substr($state,0,1);

        Log::info('val',[$val]);

        // A ログイン画面
        // B 設定画面
        // C ユーザ登録画面
        
        if($val == 'A'){
            /*A.ログイン画面から起動した場合*/
            /*-----------------------------------------------
            * 取得したUserIdでusersマスタを参照する
            *  -  ある　→　1.通常ログインに進む
            *  -  ない　
            *      -  既にメールアドレスで登録済みかどうかによるが、
            *         それはこちらでは判断できないので、選択画面
            *         で選択させる
            *      -  既に登録がある→ログイン→設定画面で紐づけを行う
            *      -  登録がない→ユーザ登録画面
            *
            ------------------------------------------------*/

            //userIdで、usersマスタを参照する
            $user = User::where('line_user_id',$user_id)->first();

            if(!empty($user)){
                //1.通常のログインの場合
                // return $this->attemptLogin($request,$user);
                return redirect()->to(env('APP_URL')."/line/attemptLogin/?user_id=".$user_id);//OK
            }
            else{
                //userはあるが、LINEによるログインを設定しようとしているとき
                //全く新しくログイン情報をつくろうとしているとき
                //このいづれなのかは、こちらでは判断できないので、ユーザーに選択させる

                return redirect()->to(env('APP_URL')."/line/selectregistration");
            }
        }
        else if($val=='B'){
            /*B.設定画面から起動して、LINEプロファイルを紐づけしようとする場合*/
            // 一度ブラウザに返すために中間ページをResponseする
            // ブラウザに返して再度リクエストさせることで、SessionIDを紐づける
            // return view('settings.linecallback',$args);
            //ngrokの時におかしくなるので、ドメインから指定している
            // session()->put('user_id',$user_id);
            Log::info("user_idをクエリパラメーターに渡してリダイレクトします",[$user_id]);
            // return redirect()->to(env('APP_URL').("/line/binding/"))->with('user_id',$user_id);//上手く渡せず
            // return redirect()->to(env('APP_URL').("/line/binding/"),302,$args);//上手く渡せず
            return redirect()->to(env('APP_URL')."/line/binding/?user_id=".$user_id);//OK
            //セッションに渡す方法は上手くいかなかったので、クエリパラメーターで渡す

        }
        else if($val=='C'){
            /*C.ユーザー登録しようとする場合*/

            return redirect()->to(env('APP_URL')."/register/1/?user_id=".$user_id);//OK

        }

    }
    //ログインしてホームに遷移
    public function attemptLogin(Request $request){

        $user_id = $request->query('user_id');
        Log::info('useridがとれたか1',[$user_id]);

        //userIdで、usersマスタを参照する
        $user = User::where('line_user_id',$user_id)->first();

        //取得したユーザーを使ってログイン
        Auth::login($user,$remember = true);
        Auth::setUser($user);

        Log::info('attemptLogin成功しました',[Auth::user(),Auth::check()]);

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->to(env('APP_URL'));//OK

    }
    //GET
    public function selectRegistration(){
        return view('Settings.lineselectregistration');
    }
    //POST
    //SettingsからAPIを呼び＞callbackされた後に呼ばれる
    public function binding(Request $request){

        //クエリパラメーターから値を受け取る
        $user_id = $request->query('user_id');
        Log::info('useridがとれたか2',[$user_id]);

        //ログイン中のユーザーを取得
        $user = Auth::user();
        Log::info('userがとれたか',[$user]);

        //usersを更新
        $user->ll_enabled = 1;
        $user->line_user_id = $user_id;

        $user->save();

        //設定画面へ戻る
        return redirect('settings');
        
    }
  
    //ランダムな英数文字列を返す
    private static function makeRandStr($length) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }
}
