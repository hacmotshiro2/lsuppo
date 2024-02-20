@extends('layouts.lsuppo-admin-base-edit')

@section('title')
ユーザーとサポーターの紐づけマスタメンテ
@endsection

@section('description')
    ユーザマスタのuser_idとサポーターマスタのSupporterCdを紐づけるマスタを登録します。<br/>
    当マスタを登録することにより、サポーターの機能が使えるようになります。
@endsection

@section('editor')
<div class="">
    @if($mode=='create')
    <livewire:user2supporter-create />
    @elseif($mode=='update'||$mode=='delete')
    <livewire:user2supporter-edit />
    @else
    @endif
</div>
@endsection

@section('reference')
<div class="">
    <livewire:user2supporter-list />
</div>
@endsection