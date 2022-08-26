
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
    @else
    <p>ページ遷移が不正です</p>
    @endif
    <p><a href='\fb\'>&lt;戻る</a></p>
    </div>
</section>
@endsection