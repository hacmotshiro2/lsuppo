
@extends('layouts.lsuppo-base')

@section('title')
発表動画登録ページ
@endsection
      
@section('content')
<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
    <!-- text - start -->
    <div class="mb-10 md:mb-16">
      <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-6">発表動画登録</h2>
    </div>
    <!-- text - end -->

    <!-- form - start -->
    <form  method="POST" action="#" class="max-w-screen-md grid sm:grid-cols-2 gap-4 mx-auto">
        @csrf
        <div>
            @if($mode=='edit')
                <x-lsuppo-input type=hidden name="id" value="{{$id}}" />
            @endif
            <label for="StudentCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
            <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="StudentCd" name="StudentCd">
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($students as $student)
                    <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
                @endforeach
            @elseif($mode=='edit')
                @foreach($students as $student)
                    @if($student->StudentCd==$item->StudentCd)
                        <option value="{{$student->StudentCd}}" selected readonly >{{$student->getCdName()}}</option>
                    @endif
                @endforeach
            @endif
            </select>
        </div>
        <div class="sm:col-span-2">
            <label for="ShootingDate" class="inline-block text-gray-800 text-sm sm:text-base mb-2">発表した日*</label>
            @if($mode=='add')
                <x-lsuppo-input type="date" name="ShootingDate" class="w-full sm:w-1/3" value="{{old('ShootingDate')}}" />
            @elseif($mode=='edit')
                <x-lsuppo-input type="date" name="ShootingDate" class="w-full sm:w-1/3" value="{{$item->ShootingDate}}" />
            @endif
        </div>
        <div class="sm:col-span-2">
            <label for="Title" class="inline-block text-gray-800 text-sm sm:text-base mb-2">タイトル*</label>
            @if($mode=='add')
                <x-lsuppo-input name="Title" class="w-full sm:w-1/2" value="{{old('Title')}}" />
            @elseif($mode=='edit')
                <x-lsuppo-input name="Title" class="w-full sm:w-1/2" value="{{$item->Title}}" />
            @endif
        </div>
        <div class="sm:col-span-2">
            <label for="Description" class="inline-block text-gray-800 text-sm sm:text-base mb-2">動画の説明*</label>
            <label class="inline-block text-gray-400 text-sm sm:text-base mb-2">200字以内</label>
            <textarea id="txtaDescription" name="Description" class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2">@if($mode=='add'){{old('Description')}} @elseif($mode=='edit'){{$item->Description}} @endif</textarea>
            <p class="text-gray-500 text-sm"><span class="" id="detail_length">0</span> 字</p>
        </div>
        <div class="sm:col-span-2">
            <label for="YouTubeId" class="inline-block text-gray-800 text-sm sm:text-base mb-2">YouTubeId*</label>
            <label class="block text-gray-400 text-sm sm:text-base mb-2">https://youtu.be/B4sip78hkBA の B4sip78hkBA 部分</label>
            @if($mode=='add')
                <x-lsuppo-input name="YouTubeId" class="w-full sm:w-1/2" value="{{old('YouTubeId')}}" />
            @elseif($mode=='edit')
                <x-lsuppo-input name="YouTubeId" class="w-full sm:w-1/2" value="{{$item->YouTubeId}}" />
            @endif
        </div>
      <div class="sm:col-span-2 flex justify-end items-center">
        <span class="text-gray-500 text-sm">*Required</span>
      </div>
      <div class="sm:col-span-2 flex justify-between items-center">
        @if($mode=='edit')
        <div class="w-full flex justify-between">
            <x-lsuppo-submit formaction="/mv/presen/confirm?mode=edit" :mode="'edit'">更新確認</x-lsuppo-submit>
            <x-lsuppo-submit formaction="/mv/presen/delete" :mode="'delete'" onclick="return window.confirm('削除します。よろしいですか？')">削除</x-lsuppo-submit>
        </div>
        @elseif($mode=='add')
            <x-lsuppo-submit formaction="/mv/presen/confirm?mode=add" :mode="'add'">登録確認</x-lsuppo-submit>
        @else
        @endif
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