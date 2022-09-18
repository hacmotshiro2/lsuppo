
@extends('layouts.lsuppo-base')

@section('title')
サポーター登録ページ
@endsection
      
@section('content')
<div class="flex flex-wrap md:flex-nowrap">
    <div>
        @include('components.lsuppo-supermenu')
    </div>
    <div class="ml-4">
        <form method="POST" action="/supporter/add" class="row g-2">
            @csrf
            <div class="mb-2">
                <label for="valSupporterCd" class="form-label">サポーターコード</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valSupporterCd" name="SupporterCd" value="{{$item->SupporterCd}}" class="form-control bg-gray-200" required maxlength="8" readonly />
                @else
                    <x-lsuppo-input type="text" id="valSupporterCd" name="SupporterCd" value="{{old('SupporterCd')}}" class="bg-white" required maxlength="8" />
                @endif
            </div>
            <div class="mb-2">
                <label for="valSei" class="form-label">姓</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valSei" name="Sei" value="{{$item->Sei}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="valSei" name="Sei" value="{{old('Sei')}}" class="form-control" required />
                @endif
            </div>
            <div class="mb-2">
                <label for="valMei" class="form-label">名</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valMei" name="Mei" value="{{$item->Mei}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="valMei" name="Mei" value="{{old('Mei')}}" class="form-control" required />
                @endif
            </div>
            <div class="mb-2">
                <label for="valHurigana" class="form-label">フリガナ</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valHurigana" name="Hurigana" value="{{$item->Hurigana}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="valHurigana" name="Hurigana" value="{{old('Hurigana')}}" class="form-control" required />
                @endif
            </div>
            <div class="mb-2">
                <label for="valHyouziMei" class="form-label">表示名</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valHyouziMei" name="HyouziMei" value="{{$item->HyouziMei}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="valHyouziMei" name="HyouziMei" value="{{old('HyouziMei')}}" class="form-control" required />
                @endif
            </div>
            <div class="mb-2">
                <label for="LearningRoomCd" class="form-label">LRコード</label>
                <select class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="LearningRoomCd" name="LearningRoomCd">
                    @foreach($lrs as $lr)
                    @if($mode=='edit')
                    <option value="{{$lr->LearningRoomCd}}" @if($item->LearningRoomCd==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                    @else
                    <option value="{{$lr->LearningRoomCd}}" @if(old('LearningRoomCd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">権限レベル</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" name="authlevel" value="{{$item->authlevel}}" required maxlength="1"></x-lsuppo-input>
                @else
                    <x-lsuppo-input type="text" name="authlevel" value="{{old('authlevel')}}" required maxlength="1"></x-lsuppo-input>
                @endif 
            </div>
            <div class="mb-2">
                <label for="valRiyouFrom" class="form-label">利用期間</label>
                <div class="input-group">
                    @if($mode=='edit')
                        <x-lsuppo-input type="date" id="valRiyouKaisiDate" name="RiyouKaisiDate" value="{{$item->RiyouKaisiDate}}" class="form-control" />
                    @else
                        <x-lsuppo-input type="date" id="valRiyouKaisiDate" name="RiyouKaisiDate" value="{{old('RiyouKaisiDate')}}" class="form-control" />
                    @endif
                        <span class="input-group-text" id="inputGroupbar"> ～</span>
                    @if($mode=='edit')
                        <x-lsuppo-input type="date" id="valRiyouShuuryouDate" name="RiyouShuuryouDate" value="{{$item->RiyouShuuryouDate}}" class="form-control" />
                    @else
                        <x-lsuppo-input type="date" id="valRiyouShuuryouDate" name="RiyouShuuryouDate" value="{{old('RiyouShuuryouDate')}}" class="form-control" />
                    @endif
                </div>
            </div>
            <div class="mb-2">
                @if($mode=='edit')
                    <div class="flex justify-between">
                        <x-lsuppo-submit formaction="/supporter/edit" :mode="'edit'">更新</x-lsuppo-submit>
                        <x-lsuppo-submit formaction="/supporter/delete" :mode="'delete'">削除</x-lsuppo-submit>
                    </div>
                @elseif($mode=='add')
                    <x-lsuppo-submit formaction="/supporter/add" :mode="'add'">登録</x-lsuppo-submit>
                @else
                @endif
            </div>
        </form>
        <div id='list'>
            <table class="table-auto border-collapse border border-slate-500">       
                <tr>
                    <th class="border border-slate-600">SupporterCd</th>
                    <th class="border border-slate-600">Sei</th>
                    <th class="border border-slate-600">Mei</th>
                    <th class="border border-slate-600">Hurigana</th>
                    <th class="border border-slate-600">HyouziMei</th>
                    <th class="border border-slate-600">RiyouKaisiDate</th>
                    <th class="border border-slate-600">RiyouShuuryouDate</th>
                    <th class="border border-slate-600">LearningRoomCd</th>
                    <th class="border border-slate-600">authlevel</th>
                    <th class="border border-slate-600">IsLocked</th>
                    <th class="border border-slate-600">IsNeedPWChange</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td class="border border-slate-700"><a href="/supporter/add/?SupporterCd={{$item->SupporterCd}}" class="text-indigo-700" >{{$item->SupporterCd}}</a></td>
                    <td class="border border-slate-700">{{$item->Sei}}</td>
                    <td class="border border-slate-700">{{$item->Mei}}</td>
                    <td class="border border-slate-700">{{$item->Hurigana}}</td>
                    <td class="border border-slate-700">{{$item->HyouziMei}}</td>
                    <td class="border border-slate-700">{{$item->RiyouKaisiDate}}</td>
                    <td class="border border-slate-700">{{$item->RiyouShuuryouDate}}</td>
                    <td class="border border-slate-700">{{$item->LearningRoomCd}}</td>
                    <td class="border border-slate-700">{{$item->authlevel}}</td>
                    <td class="border border-slate-700">{{$item->IsLocked}}</td>
                    <td class="border border-slate-700">{{$item->IsNeedPWChange}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection