
@extends('layouts.lsuppo-base')

@section('title')
サポーターページ
@endsection
      
@section('content')
        <h1>サポーターページ</h1>
        <p>ID: {{$id}}</p>
        <ul>
            <li><a href="/fb/regist/">フィードバック登録</a></li>
        </ul>
@endsection