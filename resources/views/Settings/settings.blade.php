
@extends('layouts.lsuppo-base')

@section('title')
設定
@endsection
      
@section('content')

<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="max-w-screen-md px-4 md:px-8 mx-auto">
    <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-8">設定</h2>
    <div class="border rounded-lg mx-auto">
    <!-- m_hogosha関連 -->
    <!-- 今のところ更新対象無し -->
    <!-- Auth関連 -->
    <form method="POST" action="/settings/edit" >
    @csrf
      <div class="flex flex-col gap-4 p-4 md:p-8 mx-2">
        <div class="mb-4">
          <label class="inline-block text-gray-800 text-sm sm:text-base mb-2">ご登録のメールアドレス</label>
          <label class="block w-full text-gray-800 text-base sm:text-xl mb-2">{{$mail}}</label>
        </div>
        <div class="mb-4">
          <label for="username" class="inline-block text-gray-800 text-sm sm:text-base mb-2">表示名</label>
          <input name="username" value="{{$userName}}" class="w-full text-gray-800 border text-base sm:text-xl focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"/>
        </div>
        <div clas="mb-4">
          <!-- パスワード変更は後に実装 -->
          <label for="password" class="hidden inline-block text-gray-800 text-sm sm:text-base mb-2">Password</label>
          <input type="password" name="password" class="hidden w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" />
        </div>
        <button class="block bg-gray-800 hover:bg-gray-700 active:bg-gray-600 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">変更</button>
      </div>
    </form>
    {{-- ラインログイン関連 --}}
    {{-- <div class="flex flex-col gap-4 p-4 md:p-8 mx-2"> --}}
    <div class="p-4 md:p-8 mx-2">
      <label class="inline-block text-gray-800 text-sm sm:text-base mb-2">LINEでログイン</label>
      <label class="block text-gray-800  text-base sm:text-xl  mb-2">{{$llsettei}}</label>
      {{-- <a href="/line/bind" ><button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-gray-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150" style="background-color:#06C755">ラインとの紐づけを行う</button></a> --}}
      <a href="/line/bind" class="block mb-2">
        <button class="items-center text-center rounded-lg px-4 py-2 border border-transparent rounded-md font-semibold text-base text-white  tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-indigo-300 disabled:opacity-30 transition ease-in-out duration-150" style="background-color:#06C755" {{$buttonAbility}}>ラインとの紐づけを行う</button>
      </a>
    </div>
  </div>
</div>
</div>
      

@endsection