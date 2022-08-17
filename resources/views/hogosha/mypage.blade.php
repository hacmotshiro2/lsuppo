@extends('layouts.lsuppo-base')

@section('title')
<p>エルサポ マイページ</p>
@endsection
      
@section('content')
@if(isset($user))
<p>コンテンツです。（子テンプレート）</p>
@else
<p>ログインしていません。</p>
<p>(<a href = "/login">ログイン</a> | <a href = "/register">登録</a>)</p>
@endif
@endsection