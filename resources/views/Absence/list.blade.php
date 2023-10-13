
@extends('layouts.lsuppo-base')

@section('title')
欠席情報明細一覧（サポーター用）
@endsection
      
@section('content')
<div class="container px-5 py-2 mx-auto">
    <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-2.5">
        <a href="/absence/add" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録</a>
    </div>
</div>
<div class="mx-4">
    <div id='list'>
        <livewire:absence />
    </div>
</div>
@endsection