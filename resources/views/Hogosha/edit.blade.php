@extends('layouts.lsuppo-admin-base-edit')

@section('title')
保護者マスタメンテ
@endsection

@section('description')
    保護者マスタを登録します。<br/>
    保護者は生徒1人につき1つのみです。<br/>
    両親でエルサポにログインされる場合は、保護者マスタは共用で、複数のユーザを1つの保護者に紐づけます。
@endsection

@section('editor')
<div class="">
    @if($mode=='create')
    <livewire:hogosha-create />
    @elseif($mode=='update'||$mode=='delete')
    <livewire:hogosha-edit />
    @else
    @endif
</div>
@endsection

@section('reference')
<div class="">
    <livewire:hogosha-list />
</div>
@endsection