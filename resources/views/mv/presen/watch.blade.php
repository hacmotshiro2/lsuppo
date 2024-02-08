
@extends('layouts.lsuppo-base')

@section('title')
発表動画閲覧ページ
@endsection
      
@section('content')
<section>
    <div class="bg-white py-6 sm:py-8 lg:py-12">
      {{-- 生徒のループ --}}
      @foreach ($students as $student)
        <div class="mt-6 md:mt-8 ">
          <span class="font-semibold title-font text-gray-700 border-b-2">{{$student->HyouziMei}}さんの発表動画</span>
          {{-- 生徒の中の動画のループ --}}
          @if(count($itemset[$student->StudentCd])==0)
            <div class="mt-2 md:mt-4">
              <span class="text-gray-700 ">まだ発表動画はありません</span>
            </div>
          @endif
        </div>
        @foreach ($itemset[$student->StudentCd] as $item)
          <div class="max-w-screen-2xl px-4 md:px-8 mx-auto mt-8">
            @include('components.mvPresen',['item'=>$item])
          </div>
        @endforeach
      @endforeach
    </div>
</section>
@endsection