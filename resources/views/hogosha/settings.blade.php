
@extends('layouts.lsuppo-base')

@section('title')
設定
@endsection
      
@section('content')

<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="max-w-screen-md px-4 md:px-8 mx-auto">
    <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-8">設定</h2>
    <!-- m_hogosha関連 -->
    <!-- 今のところ更新対象無し -->
    <!-- Auth関連 -->
    <form method="POST" action="/settings/edit/" class="border rounded-lg mx-auto">
    @csrf
      <div class="flex flex-col gap-4 p-4 md:p-8 mx-2">
        <div class="mb-4">
          <label class="inline-block text-gray-800 text-sm sm:text-base mb-2">ご登録のメールアドレス</label>
          <label class="block w-full text-gray-800 text-sm sm:text-base mb-2">{{$mail}}</label>
        </div>
        <div class="mb-4">
          <label for="username" class="inline-block text-gray-800 text-sm sm:text-base mb-2">表示名</label>
          <input name="username" value="{{$userName}}" class="w-full text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"/>
        </div>
        <div clas="mb-4">
          <!-- パスワード変更は後に実装 -->
          <label for="password" class="hidden inline-block text-gray-800 text-sm sm:text-base mb-2">Password</label>
          <input type="password" name="password" class="hidden w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" />
        </div>
        <button class="block bg-gray-800 hover:bg-gray-700 active:bg-gray-600 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">変更</button>
      </div>
    </form>
</div>
      

@endsection