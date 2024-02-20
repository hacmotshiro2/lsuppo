@extends('layouts.lsuppo-admin-base-edit')

@section('title')
サポーターマスタメンテ
@endsection

@section('description')
    サポーターマスタを登録します。<br/>
    表示名に登録した情報は、フィードバック記入者として表示される。
@endsection

@section('editor')
<div class="">
    @if($mode=='create')
    <livewire:supporter-create />
    @elseif($mode=='update'||$mode=='delete')
    <livewire:supporter-edit />
    @else
    @endif
</div>
@endsection

@section('reference')
<div class="">
    <livewire:supporter-list />
</div>
@endsection