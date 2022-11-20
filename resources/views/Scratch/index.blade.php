@extends('layouts.lsuppo-base')

@section('title')
スクラッチプロジェクト確認ページ
@endsection
      
@section('content')
<section class="text-gray-600 body-font overflow-hidden">
  <!-- コンテンツ -->
  <div class="container px-5 py-24 mx-auto">
    <div class="-my-8 divide-y-2 divide-gray-100">
    @foreach($students as $student)
      <!-- Studentが切り替わるタイミングのみStudentNameを表示 -->
      <span class="font-semibold title-font text-gray-700 mt-10 md:mt-24">{{$student->HyouziMei}}さんの作品一覧</span>
      @if(count($itemset[$student->StudentCd])==0)
        <span class="font-semibold title-font text-gray-700 mt-10 md:mt-24">まだプロジェクトがありません</span>
      @else
      <div class="flex flex-wrap" >
        @foreach($itemset[$student->StudentCd] as $project)
          <div class="m-4 max-w-sm bg-gray-100 rounded-lg p-4 md:p-8">
            <div class="w-full"><span class="text-xl md:text-2xl font-semibold text-gray-800 title-font mb-2">{{$project['title']}}</span></div>
            <div class="w-full"><span class="text-lg md:text-xl text-gray-800 title-font mb-2">最終更新日：{{date('Y年m月d日' ,strtotime($project['history']['modified']))}}</span></div>
            <div class="w-full">
              {{-- <iframe src="https://scratch.mit.edu/projects/{{$project['id']}}/embed" allowtransparency="true" width="485" height="402" frameborder="0" scrolling="no" allowfullscreen></iframe> --}}
              <a href="https://scratch.mit.edu/projects/{{$project['id']}}" class="group block overflow-hidden">
                <img src="{{$project['image']}}" loading="lazy" class="object-cover object-center group-hover:scale-110 transition duration-200" />
              </a>
            </div>
            <div class="w-full"><span class="text-xl text-gray-700 title-font mb-2">上手くいかないときは<a href="https://scratch.mit.edu/projects/{{$project['id']}}" class="text-indigo-500">こちら</a></span></div>
          </div>
          @endforeach
        </div>
      @endif
    @endforeach
    </div>
  </div>
</section>

@endsection