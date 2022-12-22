<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GooglePhotoController extends Controller
{
    // ref:https://glitch.com/edit/#!/google-photos-embed-generator
    //
    public function index(Request $request){
        
        $links=[];

        // $regex = /\["(https:\/\/lh3\.googleusercontent\.com\/[a-zA-Z0-9\-_]*)"/g
        // $regex = "https:\/\/lh3.googleusercontent.com\/[a-zA-Z0-9\-_]*/"; //こっちだったらgoogleアカウントのアイコンなどもとれてしまった
        $regex = "/src=\"https:\/\/lh3.googleusercontent.com\/[a-zA-Z0-9\-_]*/";
        
        //google photo albumの取得
         //api用
        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'GET',
                'header'=> 'Content-type: text/html; charset=utf-8' //HTML形式で表示
            )
        );
        // ストリームコンテキストの作成
        $context = stream_context_create($options);

        // 取得URL
        // これHTMLが返ってくる ref: https://medium.com/@ValentinHervieu/how-i-used-google-photos-to-host-my-website-pictures-gallery-d49f037c8e3c
        $url = "https://photos.app.goo.gl/".env("G_PHOTO_ALBUM_ID");
            
        $raw_data = file_get_contents($url, false,$context);

        // var_dump($raw_data);
        $matches;
        $ret = preg_match_all($regex, $raw_data, $matches,PREG_PATTERN_ORDER);        
        for($i=0;$i<count($matches[0]);$i++){
            $src=$matches[0][$i];
            //scr="https~ からsrc="を除く
            $src=substr($src,5,strlen($src)-5);
            //"https://lh3.googleusercontent.com/a"を除く
            if(strlen($src)>40){
                $links[]=$src;
            }
        }

        $args=[
            'width'=>1080,
            'links'=>array_unique($links),//重複は除く
        ];
        return view("photo.index",$args);
    }
}
