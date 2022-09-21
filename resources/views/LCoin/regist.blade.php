
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
            <input type="date" name="HasseiDate" class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value=@if($mode=='add')"{{old('HasseiDate')}}" @elseif($mode='edit')"{{$form->HasseiDate}}" @endif></input>
        </div>
        <div class="my-2">
            <label for="ZiyuuCd" class="text-gray-800 text-sm sm:text-base mb-2">事由</label>
            <select class="w-2/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="ZiyuuCd" name="ZiyuuCd">
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($ziyuus as $ziyuu)
                    <option value="{{$ziyuu->ZiyuuCd}}" @if(old('ZiyuuCd')==$ziyuu->ZiyuuCd) selected @endif data-da="{{$ziyuu->DefaultAmount}}">{{$ziyuu->getCdName()}} {{$ziyuu->DefaultAmount}}</option>
                @endforeach
            @elseif($mode=='edit')
            @endif
            </select>
        </div>
        <div class="my-2">
            <label for="Amount" class="inline-block text-gray-800 text-sm sm:text-base mb-2">コイン数量　※減額の場合はマイナスで入力</label>
            @if($mode=='add')
                <x-lsuppo-input type="number" id="txtAmount" name="Amount" value="{{old('Amount')}}" ></x-lsuppo-input>
            @elseif($mode=='edit')
                <x-lsuppo-input type="number" id="txtAmount" name="Amount" value="{{$form->Amount}}" ></x-lsuppo-input>
            @endif
        </div>
        <div class="my-2">
            <label for="ZiyuuHosoku" class="inline-block text-gray-800 text-sm sm:text-base mb-2">事由補足　※デフォルトから数量を変更する場合はその旨も記載</label>
            <input type="text" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"  name="ZiyuuHosoku" 
            value=@if($mode=='add')"{{old('ZiyuuHosoku')}}" @elseif($mode=='edit')"{{$form->ZiyuuHosoku}}" @endif />
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
@section('pageScript')
<script>
    document.addEventListener('DOMContentLoaded',function(){
        var el = document.getElementById('ZiyuuCd');
        el.addEventListener('change', function(){
            //変更されたら
            // console.log('変更された');
            var i = el.selectedIndex;
            // console.log(i);
            var dAmount =  el.options[i].getAttribute('data-da');

            var txt = document.getElementById('txtAmount');
            if(txt.value === ''){
                // console.log('テキストの値は空です');
                // console.log(dAmount);
                //空の場合に、初期値をセットする
                txt.value = dAmount;
            }
        });
    });
</script>
@endsection