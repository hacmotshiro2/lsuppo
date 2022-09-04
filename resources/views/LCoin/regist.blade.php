
@extends('layouts.lsuppo-base')

@section('title')
エルコイン登録ページ
@endsection
      
@section('content')
<form method="POST" action="/lc/add" class="row g-2">
@csrf
    <div class="flex-col mx-4 md:mx-12">
        <div class="my-2">
            <label for="StudentCd" class="text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
            <select class="w-2/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="StudentCd" name="StudentCd">
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
        <div class="my-2">
            <label for="HasseiDate" class="text-gray-800 text-sm sm:text-base mb-2">発生日*</label>
            <input type="date" name="HasseiDate" class="w-full sm:w-1/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value=@if($mode=='add')"{{old('HasseiDate')}}" @elseif($mode='edit')"{{$form->HasseiDate}}" @endif></input>
        </div>
        <div class="my-2">
            <label for="ZiyuuCd" class="text-gray-800 text-sm sm:text-base mb-2">事由</label>
            <select class="w-2/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="ZiyuuCd" name="ZiyuuCd">
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($ziyuus as $ziyuu)
                    <option value="{{$ziyuu->ZiyuuCd}}" @if(old('ZiyuuCd')==$ziyuu->ZiyuuCd) selected @endif >{{$ziyuu->getCdName()}}</option>
                @endforeach
            @elseif($mode=='edit')
                    <option value="{{$students[0]->StudentCd}}" selected readonly>{{$students[0]->getCdName()}}</option>
            @endif
            
            </select>
        </div>
        <div class="my-2">
            <label for="ZiyuuHosoku" class="inline-block text-gray-800 text-sm sm:text-base mb-2">事由補足</label>
            <input type="text" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"  name="ZiyuuHosoku" 
            value=@if($mode=='add')"{{old('ZiyuuHosoku')}}" @elseif($mode=='edit')"{{$form->ZiyuuHosoku}}" @endif />
        </div>
        <div class="my-2">
            <label for="Amount" class="inline-block text-gray-800 text-sm sm:text-base mb-2">コイン数量　※減額の場合はマイナスで入力</label>
            <input type="number" name="Amount" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" required
            value=@if($mode=='add')"{{old('Amount')}}" @elseif($mode=='edit')"{{$form->Amount}}" @endif /></input>
        </div>
        <div class="my-2">
            <label for="TourokuSupporterCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">登録サポーターコード</label>
            <input type="text" name="TourokuSupporterCd" value="{{$TourokuSupporterCd}}" class="w-full bg-gray-100 text-gray-800 border rounded outline-none px-3 py-2" readonly></input>
        </div>
        <div class="my-2">
            <input type="submit" name="create" value="登録" class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3" >
        </div>
    </div>
</form>
@endsection