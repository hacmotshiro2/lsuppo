
@extends('layouts.lsuppo-base')

@section('title')
システム管理者ページ
@endsection
      
@section('content')
        <h1>システム管理者ページ</h1>
        <ul class="list-decimal">
            <li><a href="/student/add/">生徒登録</a></li>
            <li><a href="/hogosha/add/">保護者登録</a></li>
            <li><a href="/user2hogosha/add/">ユーザーと保護者の紐づけ登録</a></li>
            <li><a href="/fb/regist/">サポーター登録</a></li>
            <li><a href="/fb/regist/">ラーニングルーム登録</a></li>
            <li><a href="/lc/regist/">エルコイン登録</a></li>
        </ul>

@endsection