@extends('layouts.lsuppo-admin-base-list')

@section('title')
発表動画一覧
@endsection
      
@section('list')
<div class="">
    <!-- 新規登録ボタン -->
    <div class="container px-5 py-2 mx-auto">
        <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-2.5">
            <a href="/mv/presen/edit" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録</a>
        </div>
    </div>
    <div>
        <livewire:mv-list />
    </div>
</div>
@endsection