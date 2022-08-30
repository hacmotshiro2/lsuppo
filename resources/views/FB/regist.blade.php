
@extends('layouts.lsuppo-base')

@section('title')
フィードバック登録ページ
@endsection
      
@section('content')
<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
    <!-- text - start -->
    <div class="mb-10 md:mb-16">
      <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-6">フィードバック登録</h2>
      <p class="max-w-screen-md text-gray-500 md:text-lg text-center mx-auto">対象期間にどのようなことに取り組み、どういった点で努力したのか。<br>どういった点で力がついたのか、具体的に前向きな表現で記述するようにしてください。</p>
    </div>
    <!-- text - end -->

    <!-- form - start -->
    @if($mode=='add')
    <form  method="POST" action="/fb/add/" class="max-w-screen-md grid sm:grid-cols-2 gap-4 mx-auto">
    @elseif($mode=='edit')
    <form  method="POST" action="/fb/edit/" class="max-w-screen-md grid sm:grid-cols-2 gap-4 mx-auto">
    @else
    @endif
        @csrf
        <div>
            @if($mode=='edit')
            <input type=hidden name="fbNo" value="{{$fbNo}}">
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
                    <option value="{{$students[0]->StudentCd}}" selected readonly>{{$students[0]->getCdName()}}</option>
            @endif
            </select>
        </div>
        <div>
            <label for="LearningRoomCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">LRコード*</label>
            <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="LearningRoomCd" name="LearningRoomCd">
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($lrs as $lr)
                    <option value="{{$lr->LearningRoomCd}}" @if(old('LearningRoomCd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                @endforeach
            @elseif($mode=='edit')
                @foreach($lrs as $lr)
                    <option value="{{$lr->LearningRoomCd}}" @if($form->LearningRoomCd==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                @endforeach
            @endif
            </select>
        </div>
        <div class="sm:col-span-2">
            <label for="Title" class="inline-block text-gray-800 text-sm sm:text-base mb-2">タイトル*</label>
            <input name="Title" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value=@if($mode=='add')"{{old('Title')}}" @elseif($mode=='edit')"{{$form->Title}}" @endif />
        </div>
        <div class="sm:col-span-2">
            <label for="Detail" class="inline-block text-gray-800 text-sm sm:text-base mb-2">フィードバック詳細*</label>
            <label class="inline-block text-gray-400 text-sm sm:text-base mb-2">200字～300字程度</label>
            <textarea id="txtaDetail" name="Detail" class="w-full h-64 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" >@if($mode=='add'){{old('Detail')}} @elseif($mode=='edit'){{$form->Detail}} @endif</textarea>
            <p class="text-gray-500 text-sm"><span class="" id="detail_length">0</span> 字</p>
        </div>
        <div class="sm:col-span-2">
            <label for="TaishoukikanFrom" class="inline-block text-gray-800 text-sm sm:text-base mb-2">対象期間*</label>
            <input type="date" name="TaishoukikanFrom" class="w-full sm:w-1/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value=@if($mode=='add')"{{old('TaishoukikanFrom')}}" @elseif($mode='edit')"{{$form->TaishoukikanFrom}}" @endif></input>
            <span class="input-group-text" id="inputGroupbar"> ～</span>
            <input type="date" name="TaishoukikanTo" class="w-full sm:w-1/3  bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value=@if($mode=='add')"{{old('TaishoukikanTo')}}" @elseif($mode='edit')"{{$form->TaishoukikanTo}}" @endif></input>
        </div>
        <div class="sm:col-span-2 flex justify-between items-center">
            <label for="KinyuuSupporterCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">記入サポーターコード</label>
            <input type="text" name="KinyuuSupporterCd" value="{{$KinyuuSupporterCd}}" class="w-full bg-gray-100 text-gray-800 border rounded outline-none px-3 py-2" readonly></input>
        </div>
      <div class="sm:col-span-2 flex justify-between items-center">
        <button class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">
            @if($mode=='add')
             登録 
            @elseif($mode=='edit')
             更新 
            @endif</button>
        <span class="text-gray-500 text-sm">*Required</span>
      </div>

    </form>
    <!-- form - end -->
  </div>
</div>

@endsection