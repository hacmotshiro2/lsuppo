
@extends('layouts.lsuppo-base')

@section('title')
発表動画登録ページ ～確認～
@endsection
      
@section('content')
<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="px-4 md:px-8 mx-auto">
    <!-- text - start -->
    <div class="mb-10 md:mb-16">
      <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-6">発表動画登録 ～確認～</h2>
    </div>
    <!-- text - end -->

    <!-- form - start -->
    <form  method="POST" action="#" class="grid sm:grid-cols-2 gap-4 mx-auto">
        @csrf
        <div>
            <x-lsuppo-input type=hidden name="id" value="{{$id}}" />
            <label for="StudentCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
            <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="StudentCd" name="StudentCd">
            @foreach($students as $student)
                @if($student->StudentCd==$item->StudentCd)
                    <option value="{{$student->StudentCd}}" selected readonly >{{$student->getCdName()}}</option>
                @endif
            @endforeach
            </select>
        </div>
        <div class="sm:col-span-2">
            <label for="ShootingDate" class="inline-block text-gray-800 text-sm sm:text-base mb-2">発表した日*</label>
            <x-lsuppo-input type="date" name="ShootingDate" class="w-full sm:w-1/3" value="{{$item->ShootingDate}}" readonly/>
        </div>
        <div class="sm:col-span-2">
            <label for="Title" class="inline-block text-gray-800 text-sm sm:text-base mb-2">タイトル*</label>
            <x-lsuppo-input name="Title" class="w-full sm:w-1/2" value="{{$item->Title}}"  readonly/>
        </div>
        <div class="sm:col-span-2">
            <label for="Description" class="inline-block text-gray-800 text-sm sm:text-base mb-2">動画の説明*</label>
            <label class="inline-block text-gray-400 text-sm sm:text-base mb-2">200字以内</label>
            <textarea id="txtaDescription" name="Description" class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" readonly>{{$item->Description}}</textarea>
        </div>
        <div class="sm:col-span-2">
            <label for="YouTubeId" class="inline-block text-gray-800 text-sm sm:text-base mb-2">YouTubeId*</label>
            <x-lsuppo-input name="YouTubeId" class="w-full sm:w-1/2" value="{{$item->YouTubeId}}" readonly/>
        </div>
        <div class="sm:col-span-2">
            @include('components.mvPresen',['item'=>$item])
        </div>
      <div class="sm:col-span-2 flex justify-between items-center">
        <div class="w-full flex justify-between">
            <button class="rounded-md bg-gray-300 text-gray-700 px-4 py-2" onClick="history.back();">戻る</button>
            @if($mode=='edit')
            <div class="flex justify-between">
                <x-lsuppo-submit formaction="/mv/presen/edit" :mode="'edit'">更新</x-lsuppo-submit>
            </div>
            @elseif($mode=='add')
                <x-lsuppo-submit formaction="/mv/presen/create" :mode="'add'">登録</x-lsuppo-submit>
            @else
            @endif
        </div>
    </div>
    </form>
    <!-- form - end -->
  </div>
</div>

@endsection

@section('pageScript')
<script>
    // FB登録画面で、文字数をカウントします
    const textarea = document.querySelector('#txtaDescription');
    const detail_length = document.querySelector('#detail_length');
    //イベント登録
    textarea.addEventListener('keyup', onKeyUp);
    function onKeyUp(){
        detail_length.innerText = textarea.value.length;
    }
</script>
@endsection