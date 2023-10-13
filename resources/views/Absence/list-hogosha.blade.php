
@extends('layouts.lsuppo-base')

@section('title')
欠席情報明細一覧
@endsection
      
@section('content')
<div class="container px-5 py-2 mx-auto">
    <livewire:absence-hogosha />
</div>
@endsection