@extends('layouts.lsuppo-admin-base-edit')

@section('title')
発表動画登録画面
@endsection

@section('description')
    発表動画を登録します。<br/>
    登録・更新ボタン押下後確認画面に遷移します。
@endsection

@section('editor')
<div class="">
    <div class="row g-2" >
        <div class="block sm:flex-col sm:grid sm:grid-cols-3 sm:gap-4 sm:auto-cols-fr" >
            @if($mode=='update'||$mode=='delete')
                <x-lsuppo-input type=hidden name="id" value="{{$id}}" />
            @endif
            <label for="StudentCd" class="text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
            <div  class="sm:col-span-2 mb-2 sm:mb-0">
                <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="StudentCd" name="StudentCd">
                @if($mode=='create')
                    <!-- 空白行入れる -->
                        <option value="" >----</option>
                    @foreach($students as $student)
                        <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
                    @endforeach
                @elseif($mode=='update'||$mode=='delete')
                    @foreach($students as $student)
                        @if($student->StudentCd==$item->StudentCd)
                            <option value="{{$student->StudentCd}}" selected readonly >{{$student->getCdName()}}</option>
                        @endif
                    @endforeach
                @endif
                </select>
            </div>
            <label for="ShootingDate" class="inline-block text-gray-800 text-sm sm:text-base mb-2">発表した日*</label>
            <div  class="sm:col-span-2 mb-2 sm:mb-0">
            @if($mode=='create')
                <x-lsuppo-input type="date" name="ShootingDate" class="w-full sm:w-1/3" value="{{old('ShootingDate')}}" />
            @elseif($mode=='update'||$mode=='delete')
                <x-lsuppo-input type="date" name="ShootingDate" class="w-full sm:w-1/3" value="{{$item->ShootingDate}}" />
            @endif
            </div>
            <label for="Title" class="inline-block text-gray-800 text-sm sm:text-base mb-2">タイトル*</label>
            <div class="sm:col-span-2 mb-2 sm:mb-0">
                @if($mode=='create')
                    <x-lsuppo-input name="Title" class="w-full sm:w-1/2" value="{{old('Title')}}" />
                @elseif($mode=='update'||$mode=='delete')
                    <x-lsuppo-input name="Title" class="w-full sm:w-1/2" value="{{$item->Title}}" />
                @endif
            </div>
            <div>
                <label for="Description" class="inline-block text-gray-800 text-sm sm:text-base mb-2">動画の説明*</label>
                <label class="inline-block text-gray-400 text-sm sm:text-base mb-2">200字以内</label>
            </div>
            <div class="sm:col-span-2 mb-2 sm:mb-0">
                <textarea id="txtaDescription" name="Description" class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2">@if($mode=='create'){{old('Description')}} @elseif($mode=='update'||$mode=='delete'){{$item->Description}} @endif</textarea>
                <p class="text-gray-500 text-sm"><span class="" id="detail_length">0</span> 字</p>
            </div>
            <label for="YouTubeId" class="inline-block text-gray-800 text-sm sm:text-base mb-2">YouTubeId*</label>
            <div class="sm:col-span-2 mb-2 sm:mb-0 block">
                @if($mode=='create')
                <x-lsuppo-input name="YouTubeId" class="w-full sm:w-1/2" value="{{old('YouTubeId')}}" />
                @elseif($mode=='update'||$mode=='delete')
                <x-lsuppo-input name="YouTubeId" class="w-full sm:w-1/2" value="{{$item->YouTubeId}}" />
                @endif
                <label class="block text-gray-400 text-sm sm:text-base mb-2">https://youtu.be/jNQXAC9IVRw の jNQXAC9IVRw 部分</label>
            </div>
            <div class="sm:col-span-2 flex justify-end items-center">
                <span class="text-gray-500 text-sm">*Required</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('reference')
<div class="">
    <livewire:mv-list />
</div>
@endsection

@section('pageScript')
<script>
    // 文字数をカウントします
    const textarea = document.querySelector('#txtaDescription');
    const detail_length = document.querySelector('#detail_length');
    //イベント登録
    textarea.addEventListener('keyup', onKeyUp);
    function onKeyUp(){
        detail_length.innerText = textarea.value.length;
    }
</script>
@endsection