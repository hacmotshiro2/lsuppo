@extends('layouts.lsuppo-admin-base-edit')

@section('title')
生徒マスタメンテ
@endsection

@section('description')
    生徒マスタを登録します。<br/>
    使用していない項目：ScratchURL,RiyouKaisiDate,IsLocked,IsNeedPWChange
@endsection

@section('editor')
<div class="">
    @if($mode=='create')
    <livewire:student-create />
    @elseif($mode=='update'||$mode=='delete')
    <livewire:student-edit />
    @else
    @endif
</div>
@endsection

@section('reference')
<div class="">
    <livewire:student-list />
</div>
@endsection