
@extends('layouts.lsuppo-base')

@section('title')
フィードバック詳細確認ページ
@endsection
      
@section('content')
<section>
    @if(isset($item))
    <div class=" flex flex-col items-center px-5 py-8 mx-auto">
        <div class="flex flex-col w-full mb-8 prose text-left max-w-max lg:max-w-2xl">
            <div class="w-full mx-auto">
                <h1 class="text-gray-800 text-2xl sm:text-3xl font-bold text-center mb-4 md:mb-6">{{$item->Title}}</h1>
                <h3 class="text-gray-600 sm:text-lg mb-2 ">記入者：</h3>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->kinyuusupporter->HyouziMei}}</p>
                <p class="text-gray-800 sm:text-lg mb-8 md:mb-10">{{$item->Detail}}</p>
                <h3 class="text-gray-500 sm:text-lg mb-2 ">対象期間：</h3>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->getTaishoukikanSTR()}}</P>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->getTaishoukikanTo}}</P>
            </div>
        </div>
        <!-- 承認ボタンエリア -->
        @canany(['supporter-auth-5','supporter-auth-9'])
        <form method="POST" action="/fb/approve/" class="w-full">
            <input type="hidden" name="fbNo" value="{{$item->FbNo}}">
            <div class="w-full md:w-1/2 px-5 py-2 mx-auto mb-10">
                <div class="flex justify-center gap-2.5">
                    <button formaction="/fb/approve/" class="w-full md:w-1/2 block bg-indigo-400 hover:bg-indigo-600 active:bg-indigo-600 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">承認</button>
                    <button formaction="/fb/reject/" class="w-full md:w-1/2 block bg-red-400 hover:bg-red-600 active:bg-red-600 focus-visible:ring ring-red-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">取り下げ</button>
                </div>
            </div>
        </form>
        @endcanany

        @else
        <p>ページ遷移が不正です</p>
        @endif
        @can('hogosha-binded')
        <p><a href='\fb\'>&lt;戻る</a></p>
        @endcan
        @can('supporter-binded')
        <p><a href='\fb\index_sp'>&lt;戻る</a></p>
        @endcan
    </div>
</section>
@endsection