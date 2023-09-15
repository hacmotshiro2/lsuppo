
@extends('layouts.lsuppo-base')

@section('title')
欠席情報登録ページ
@endsection
      
@section('content')
<form method="POST" action="/absence/add" class="row g-2">
@csrf
    <div class="flex-col mx-4 md:mx-12">
        <div class="my-2">
            @if($mode=='edit')
            <input type=hidden name="id" value="{{$id}}">
            @endif
            <label for="StudentCd" class="text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
            <select class="w-2/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="StudentCd" name="StudentCd">
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($students as $student)
                    <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
                @endforeach
            @elseif($mode=='edit')
                    <option value="{{$item->StudentCd}}" selected readonly>{{$item->student->getCdName()}}</option>
            @endif
            </select>
        </div>
        <div class="my-2">
            <label for="AbsentDate" class="text-gray-800 text-sm sm:text-base mb-2">欠席年月日*</label>
            <input type="date" name="AbsentDate" class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="{{ $mode === 'add' ? old('AbsentDate') : $item->AbsentDate }}">
        </div>
        <div class="my-2">
            <label for="NotifiedDatetime" class="text-gray-800 text-sm sm:text-base mb-2">欠席連絡受付日時*</label>
            <input type="datetime-local" name="NotifiedDatetime" class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="{{ $mode === 'add' ? old('NotifiedDatetime') : $item->NotifiedDatetime }}">
        </div>
        <div class="my-2">
            <label for="ToYoteiDate" class="text-gray-800 text-sm sm:text-base mb-2">振替先予定日</label>
            <input type="date" name="ToYoteiDate" class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="{{ $mode === 'add' ? old('ToYoteiDate') : $item->ToYoteiDate }}">
        </div>
        <div class="my-2">
            <label for="ToActualDate" class="text-gray-800 text-sm sm:text-base mb-2">振替先実績日</label>
            <input type="date" name="ToActualDate" class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="{{ $mode === 'add' ? old('ToActualDate') : $item->ToActualDate }}">
        </div>
        <div class="my-2">
            <label for="ExpirationDate" class="text-gray-800 text-sm sm:text-base mb-2">振替期限日</label>
            <input type="date" name="ExpirationDate" class="bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="{{ $mode === 'add' ? old('ExpirationDate') : $item->ExpirationDate }}">
        </div>
        <div class="my-2">
        </div>
        <div class="my-2">
            <label for="LCZiyuuCd" class="text-gray-800 text-sm sm:text-base mb-2">事由*</label>
            <select class="w-2/3 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" id="LCZiyuuCd" name="LCZiyuuCd">
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($ziyuus as $ziyuu)
                    <option value="{{$ziyuu->ZiyuuCd}}" @if(old('LCZiyuuCd')==$ziyuu->ZiyuuCd) selected @endif data-da="{{$ziyuu->DefaultAmount}}">{{$ziyuu->getCdName()}} {{$ziyuu->DefaultAmount}}</option>
                @endforeach
            @elseif($mode=='edit')
                    <option value="{{$item->LCZiyuuCd}}" selected readonly>{{$item->ziyuu->getCdName()}}</option>
            @endif
            </select>
        </div>
        <div class="my-2">
            <label for="LCYoteiAmountImm" class="inline-block text-gray-800 text-sm sm:text-base mb-2">付与予定コイン数量（即時の場合）*</label>
            <x-lsuppo-input type="number" id="txtLCYoteiAmountImm" name="LCYoteiAmountImm" value="{{ $mode === 'add' ? old('LCYoteiAmountImm') : $item->LCYoteiAmountImm }}"></x-lsuppo-input>
        </div>
        <div class="my-2">
            <label for="LCYoteiAmountExp" class="inline-block text-gray-800 text-sm sm:text-base mb-2">付与予定コイン数量（期限切れの場合）*</label>
            <x-lsuppo-input type="number" id="txtLCYoteiAmountExp" name="LCYoteiAmountExp" value="{{ $mode === 'add' ? old('LCYoteiAmountExp') : $item->LCYoteiAmountExp }}"></x-lsuppo-input>
        </div>
        <div class="my-2">
            <label for="LCZiyuuHosoku" class="inline-block text-gray-800 text-sm sm:text-base mb-2">事由補足　※デフォルトから数量を変更する場合はその旨も記載</label>
            <x-lsuppo-input type="text" name="LCZiyuuHosoku" value="{{ $mode === 'add' ? old('LCZiyuuHosoku') : $item->LCZiyuuHosoku }}"></x-lsuppo-input>
        </div>
        <div class="my-2">
            <label for="TourokuSupporterCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">登録サポーターコード</label>
            <x-lsuppo-input type="text" name="TourokuSupporterCd" value="{{ $mode === 'add' ? $TourokuSupporterCd : $item->TourokuSupporterCd }}" readonly></x-lsuppo-input>
        </div>
        <div class="flex my-2">
            <div class="my-2">
                <a href="/absence/list">
                    <input type="button" name="back" value="一覧へ戻る" class="inline-block bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus-visible:ring ring-gray-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3" >
                </a>
            </div>
            <div class="my-2 ml-4">
                @if($mode=='edit')
                    <div class="flex justify-between">
                        <x-lsuppo-submit formaction="/absence/edit" :mode="'edit'">更新</x-lsuppo-submit>
                        <x-lsuppo-submit formaction="/absence/delete" :mode="'delete'" class="ml-4">削除</x-lsuppo-submit>
                    </div>
                @elseif($mode=='add')
                    <x-lsuppo-submit formaction="/absence/add" :mode="'add'">登録</x-lsuppo-submit>
                @else
                @endif
            </div>
        </div>
    </div>
</form>
@endsection
@section('pageScript')

@endsection