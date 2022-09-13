
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
                <h3 class="inline text-gray-700 sm:text-lg">お子様のお名前：</h3>
                <p class="inline text-gray-700 sm:text-lg mb-6 md:mb-8">{{$item->student->HyouziMei}} さん</p>
                <h1 class="text-gray-800 text-2xl sm:text-3xl font-bold my-4 md:my-6">{{$item->Title}}</h1>
                <p class="text-gray-800 sm:text-lg mb-8 md:mb-10">{!!nl2br(e($item->Detail))!!}</p>
                <h3 class="text-gray-600 sm:text-lg mb-2 ">記入者：</h3>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->kinyuusupporter->HyouziMei}}</p>
                <h3 class="text-gray-500 sm:text-lg mb-2 ">対象期間：</h3>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->getTaishoukikanSTR()}}</P>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->getTaishoukikanTo}}</P>
                @can('supporter-binded')
                <h3 class="text-gray-500 sm:text-lg mb-2 ">承認状態：</h3>
                <p class="text-gray-500 sm:text-lg mb-6 md:mb-8">{{$item->getShouninStatusName()}}</P>
                @endcan

            </div>
            @can('hogosha-binded')
            <p><a class="text-indigo-500" href='\fb\'>&lt;戻る</a></p>
            @endcan
            @can('supporter-binded')
            <div class="mb-32">
                <p><a class="text-indigo-500" href='\fb\index_sp'>&lt;戻る</a></p>
                <div class="w-full px-5 py-2 mx-auto mb-8">
                    @include('components.approve-history')
                </div>
            </div>
            @endcan
        </div>
        <!-- 承認ボタンエリア -->
        @canany(['supporter-auth-5','supporter-auth-9'])
        <div class="w-full fixed  bg-slate-100 opacity-90 bottom-1 z-40 mb-6">
            <form method="POST" action="/fb/approve" class="w-full lg:max-w-2xl mx-auto px-5 box-border">
                @csrf
                <input type="hidden" name="fbNo" value="{{$item->FbNo}}">
                <div class="w-full py-2 mx-auto mb-2 right-0">
                    @if($item->ShouninStatus == App\Consts\DBConst::SHOUNIN_STATUS_APPROVING)
                    <!-- 承認中の時だけ有効 -->
                    <div class="flex justify-center gap-2.5">
                        <button formaction="/fb/approve" class="w-full block bg-indigo-400 opacity-100 hover:bg-indigo-600 active:bg-indigo-600 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">承認</button>
                        <button formaction="/fb/decline" class="w-full block bg-red-400 opacity-100 hover:bg-red-600 active:bg-red-600 focus-visible:ring ring-red-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">取り下げ</button>
                    </div>
                    @else
                    <div class="flex justify-center gap-2.5">
                        <button disabled class="w-full block bg-indigo-300 opacity-100 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">承認</button>
                        <button disabled class="w-full block bg-red-300 opacity-100 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">取り下げ</button>
                    </div>
                    @endif
                </div>
                <div class="w-full py-2 mx-auto">
                    <textarea name="Comment" rows="3" class="w-full bg-gray-50 opacity-100 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" >{{old('Comment')}} </textarea>
                </div>
            </form>
        <div>
        @endcanany
        @else
        <p>ページ遷移が不正です</p>
        @endif
    </div>
</section>
@endsection