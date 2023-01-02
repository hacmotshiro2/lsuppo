
@extends('layouts.lsuppo-base')

@section('title')
設定
@endsection
      
@section('content')

<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="max-w-screen-md px-4 md:px-8 mx-auto">
    <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-8">設定</h2>
      <div class="border rounded-lg mx-auto divide-y-2 divide-gray-100">
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
          <h2 class="block text-gray-800 text-sm sm:text-base mb-2"> - LINEでログイン - </h2>
          <label class="inline-block text-gray-800  text-base sm:text-xl mb-2">設定状況：</label>
          <label class="inline-block text-gray-800  text-base sm:text-xl mb-2">{{$llsettei?"設定済み":"未設定"}}</label>
          {{-- <a href="/line/bind" ><button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-gray-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150" style="background-color:#06C755">ラインとの紐づけを行う</button></a> --}}
          <a href="/line/bind" class="block mb-2">
            <button class="w-2/5 items-center text-center rounded-lg px-4 py-2 border border-transparent rounded-md font-semibold text-base text-white  tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-indigo-300 disabled:opacity-30 transition ease-in-out duration-150" style="background-color:#06C755" {{$llsettei?'disabled':''}}>LINEとの紐づけを行う</button>
          </a>
        </div>
        {{-- 通知関連 --}}
        @if($canEditNoti)
        <div class="p-4 md:p-8 mx-2">
          <h2 class="block text-gray-800 text-sm sm:text-base mb-2"> - 通知関連 - </h2>
          <label class="block text-gray-700 text-sm sm:text-base mb-2">※通知先にLINEを設定するためには、エルサポ公式アカウントを友だち追加する必要があります</label>
          <label class="inline-block text-gray-800 text-base sm:text-xl mb-2">友だち追加状況：</label>
          <label class="inline-block text-gray-800 text-base sm:text-xl mb-2">{{$isFriend?"済":"未"}}</label>
          <form method="GET" action="/settings">
            @csrf
            <button class="w-2/5 items-center text-center rounded-lg px-4 py-2 border border-transparent rounded-md font-semibold text-base text-white  tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-indigo-300 disabled:opacity-30 transition ease-in-out duration-150" style="background-color:#06C755">再チェック</button>
          </form>
          <div class="mt-4 md:mt-8 p-4 border-dotted border-2 border-gray-700 bg-gray-100" >
            <label class="block text-gray-700 text-sm sm:text-base mb-2">友だち追加はこちらから</label>
            <a href="https://lin.ee/jUova9X"><img class="" src="https://scdn.line-apps.com/n/line_add_friends/btn/ja.png" alt="友だち追加" height="18" border="0"></a>
          </div>
          <div>
            <form method="POST" action="/settings/editNotification">
              @csrf
              <label class="inline-block text-gray-800  text-base sm:text-xl mt-4 md:mt-8 mb-2">通知先の設定</label>
              <div class="form-check form-check-inline">
                  <input type="radio" name="notiType" class="form-check-input" value="mail" {{ old ('notiType') == 'mail' ? 'checked' : '' }} checked>
                  <label class="form-check-label">メール</label>
              </div>
              <div class="form-check form-check-inline mb-2">
                  <input type="radio" name="notiType" class="form-check-input" value="line" {{ old ('notiType') == 'line' ? 'checked' : '' }} {{$isFriend?"":"disabled"}}>
                  <label class="form-check-label">LINE</label>
              </div>
              <button class="block w-2/5 bg-gray-800 hover:bg-gray-700 active:bg-gray-600 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">通知先の変更</button>
            </form>
          </div>
        </div>
        @endif
      </div>
      <!-- m_hogosha関連 -->
      <!-- 今のところ更新対象無し -->
  </div>
</div>
      

@endsection