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
        @foreach($itemset[$student->StudentCd] as $project)
        <div class="py-8 flex flex-nowrap" >
          <div class="ml-4 flex-grow">
            <div class="w-full"><span class="text-xl md:text-2xl font-semibold text-gray-800 title-font mb-2">{{$project['title']}}</span></div>
            <div class="w-full"><span class="text-xl md:text-2xl text-gray-800 title-font mb-2">最終更新日：{{date('Y年m月d日' ,strtotime($project['history']['modified']))}}</span></div>
            <div class="w-full">
              <iframe src="https://scratch.mit.edu/projects/{{$project['id']}}/embed" allowtransparency="true" width="485" height="402" frameborder="0" scrolling="no" allowfullscreen></iframe>
            </div>
            <div class="w-full"><span class="text-xl text-gray-700 title-font mb-2">上手くいかないときは<a href="https://scratch.mit.edu/projects/{{$project['id']}}" class="text-indigo-500">こちら</a></span></div>
          </div>
        </div>
        @endforeach
      @endif
    @endforeach
    </div>
  </div>
</section>

@endsection