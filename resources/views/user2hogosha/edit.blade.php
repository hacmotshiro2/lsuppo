@extends('layouts.lsuppo-admin-base-edit')

@section('title')
ユーザーと保護者の紐づけマスタメンテ
@endsection

@section('description')
    ユーザマスタのuser_idと保護者マスタのHogoshaCdを紐づけるマスタを登録します。<br/>
    当マスタを登録することにより、保護者の機能が使えるようになります。
@endsection

@section('editor')
<div class="">
    @if($mode=='create')
    <livewire:user2hogosha-create />
    @elseif($mode=='update'||$mode=='delete')
    <livewire:user2hogosha-edit />
    @else
    @endif
</div>
@endsection

@section('reference')
<div class="">
    <livewire:user2hogosha-list />
</div>
@endsection