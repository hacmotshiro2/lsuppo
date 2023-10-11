
@extends('layouts.lsuppo-base')

@section('title')
エルコイン登録明細
@endsection
      
@section('content')

<div class="bg-white py-2 sm:py-8 lg:py-12">
  <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
    <div class="container px-5 py-2 mx-auto">
      <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-2.5">
          <a href="/lc/add" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録</a>
          <a href="/lc/addnoab" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録（単独）</a>
      </div>
    </div>
    <div>
      <livewire:lcoin-list/>
    </div>
  </div>
</div>

@endsection