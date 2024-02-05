@extends('layouts.lsuppo-base')

@section('title')
通知ログ一覧
@endsection
      
@section('content')
<div class="container px-5 py-2 mx-auto">
    <div id='list'>
        <livewire:notification-logs />
    </div>
</div>
@endsection