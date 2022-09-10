@extends('layouts.lsuppo-base')

@section('title')
フィードバック確認ページ
@endsection
      
@section('content')
<section class="text-gray-600 body-font overflow-hidden">
  <!-- 新規登録ボタンエリア -->
  @can('supporter-binded')
  <div class="container px-5 py-2 mx-auto">
    <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-2.5">
        <a href="/fb/add" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録</a>
        <a href="under construction" class="hidden inline-block bg-gray-200 hover:bg-gray-300 focus-visible:ring ring-indigo-300 text-gray-500 active:text-gray-700 text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">Take tour</a>
    </div>
  </div>
  @endcan
  <!-- コンテンツ -->
  <div class="container px-5 py-24 mx-auto">
    <div class="-my-8 divide-y-2 divide-gray-100">
    @for($i=0;$i<count($items);$i++)
      <!-- Studentが切り替わるタイミングのみStudentNameを表示 -->
      @if($i===0 or $items[$i]->StudentName!==$items[$i-1]->StudentName )
        <span class="font-semibold title-font text-gray-700 mt-10 md:mt-24">{{$items[$i]->StudentName}}さんへのフィードバック</span>
      @endif
      <div class="py-8 flex flex-nowrap" @if(is_null($items[$i]->FirstReadDate)) style="background-color:#def2f4;"@endif>
        <div class="w-20 md:w-44 md:mb-0 mb-6 flex-none grid-rows-3">
          <span class="mt-1 text-gray-700 md:title-font font-semibold row-span-2">{{$items[$i]->TaishoukikanFrom}}～</span>
          <span class="mt-1 text-gray-500 text-sm">{{$items[$i]->TaishoukikanTo}}</span>
        </div>
        <div class="ml-4 flex-grow">
          <div class="w-full"><span class="text-xl md:text-2xl @if(is_null($items[$i]->FirstReadDate))font-semibold @endif text-gray-900 title-font mb-2">{{$items[$i]->Title}}</span></div>
          <div class="w-full"><span class="leading-relaxed text-gray-700">{{mb_strimwidth($items[$i]->Detail,0,120,"...")}}</span></div>
          <div class="w-full"><span><a class="text-indigo-500 inline-flex items-center mt-4" href="\fb\detail\?fbNo={{$items[$i]->FbNo}}">もっと読む
            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14"></path>
              <path d="M12 5l7 7-7 7"></path>
            </svg>
          </a><span></div>
        </div>
        <!-- サポーターが参照する時のみ -->
        @can('supporter-binded')
        <div class="w-10 md:w-24 mx-2 md:mb-0 mb-0 flex-none">
          <div class="table w-full">
            <div class="table-row-group">
              <div class="table-row">
                <span class="mt-1 md:mt-4 w-full"><a class="text-indigo-500 items-center" href="\fb\edit\?fbNo={{$items[$i]->FbNo}}">編集</a></span>
              </div>
              <div class="table-row">
                <span class="mt-1 md:mt-4  w-full">{{$items[$i]->KinyuuSupporterName}}</span>
              </div>
              <div class="table-row">
                <span class="mt-1 md:mt-4  w-full">{{$items[$i]->ShouninStatusName}}</span>
              </div>
            </div>
          </div>
        </div>
        @endcan
      </div>
    @endfor
    </div>
    @if(count($items)==0)
    <span class="font-semibold title-font text-gray-700 mt-10 md:mt-24">まだフィードバックが登録されていません</span>
    @endif
  </div>
</section>

@endsection