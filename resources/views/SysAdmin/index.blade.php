
@extends('layouts.lsuppo-base')

@section('title')
システム管理者ページ
@endsection
      
@section('content')
        <h1>super menu</h1>
        <ul class="list-disc my-8">
            <!-- <li><a href="/lr/add/">ラーニングルーム登録</a></li> -->
            <li>ラーニングルーム登録</li>
            <li><a href="/hogosha/add/">保護者登録</a></li>
            <li><a href="/student/add/">生徒登録</a></li>
            <li><a href="/user2hogosha/add/">ユーザーと保護者の紐づけ登録</a></li>
            <li><a href="/supporter/add/">サポーター登録</a></li>
            <li><a href="/user2suppo/add/">ユーザーとサポーターの紐づけ登録</a></li>
            <li><a href="/lc/list/">エルコイン登録</a></li>
        </ul>

@endsection