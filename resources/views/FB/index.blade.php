
@extends('layouts.lsuppo-base')

@section('title')
フィードバック確認ページ
@endsection
      
@section('content')
<section class="text-gray-600 body-font overflow-hidden">
  <div class="container px-5 py-24 mx-auto">
    <div class="-my-8 divide-y-2 divide-gray-100">
    @for($i=0;$i<count($items);$i++)
      @if($i===0 or $items[$i]->StudentName!==$items[$i-1]->StudentName )
        <span class="font-semibold title-font text-gray-700">{{$items[$i]->StudentName}}さんへのFEEDBACK</span>
      @endif
      <div class="py-8 flex flex-nowrap">
        <div class="w-20 md:w-44 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
          <span class="mt-1 text-gray-700 md:title-font font-semibold">{{$items[$i]->TaishoukikanFrom}}～</span>
          <span class="mt-1 text-gray-500 text-sm">{{$items[$i]->TaishoukikanTo}}</span>
        </div>
        <div class="ml-4 md:flex-grow">
          <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{$items[$i]->Title}}</h2>
          <p class="leading-relaxed">{{mb_strimwidth($items[$i]->Detail,0,240,"...")}}</p>
          <a class="text-indigo-500 inline-flex items-center mt-4" href="\fb\detail\{{$items[$i]->FbNo}}">read More
            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14"></path>
              <path d="M12 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    @endfor
    </div>
  </div>
</section>

@endsection