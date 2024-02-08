
@extends('layouts.lsuppo-base')

@section('title')
発表動画閲覧ページ
@endsection
      
@section('content')
<section>
    <div class="bg-white py-6 sm:py-8 lg:py-12">
      {{-- 新規登録ボタンエリア --}}
      <div class="container px-5 py-2 mx-auto">
        <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-2.5">
            <a href="/mv/presen/add" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">新規登録</a>
        </div>
      </div>
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
        <table class="table-auto border-separate border-spacing-2 border border-slate-500 mt-4">
          <thead>
            <tr>
              <th class="border border-slate-600">id</th>
              <th class="border border-slate-600">StudentCd</th>
              <th class="border border-slate-600">ShootingDate</th>
              <th class="border border-slate-600">Title</th>
              <th class="border border-slate-600">Description</th>
              <th class="border border-slate-600">YouTubeId</th>
              <th class="border border-slate-600">created_at</th>
              <th class="border border-slate-600">updated_at</th>
              <th class="border border-slate-600">..action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($itemset[$student->StudentCd] as $item)
            <tr>
              <td class="border border-slate-600">{{$item->id}}</td>
              <td class="border border-slate-600">{{$item->StudentCd}}</td>
              <td class="border border-slate-600">{{$item->ShootingDate}}</td>
              <td class="border border-slate-600">{{$item->Title}}</td>
              <td class="border border-slate-600">{{mb_strimwidth($item->Description,0,20,"...")}}
              <td class="border border-slate-600"><a href="https://youtu.be/{{$item->YouTubeId}}" target="_blank" >{{$item->YouTubeId}}</a></td>
              <td class="border border-slate-600">{{$item->created_at}}</td>
              <td class="border border-slate-600">{{$item->updated_at}}</td>
              <td class="border border-slate-600">
                <a href="/mv/presen/add?id={{$item->id}}">
                  <span class ="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">編集</span>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @endforeach
    </div>
</section>
@endsection