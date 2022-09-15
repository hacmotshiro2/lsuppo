
@extends('layouts.lsuppo-base')

@section('title')
保護者登録ページ
@endsection
      
@section('content')
<div class="flex flex-wrap md:flex-nowrap">
    <div>
        @include('components.lsuppo-supermenu')
    </div>
    <div class="ml-4">
        <form method="POST" action="/hogosha/add" class="row g-2">
            @csrf
            <div class="mb-2">
                <label for="valhogoshaCd" class="form-label">保護者コード</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valhogoshaCd" name="HogoshaCd" value="{{$item->HogoshaCd}}" class="form-control bg-gray-200" required maxlength="8" readonly />
                @else
                    <x-lsuppo-input type="text" id="valhogoshaCd" name="HogoshaCd" value="{{old('HogoshaCd')}}" class="bg-white" required maxlength="8" />
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
                <label for="valLearningRoomCd" class="form-label">LRコード</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valLearningRoomCd" name="LearningRoomCd" value="{{$item->LearningRoomCd}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="valLearningRoomCd" name="LearningRoomCd" value="{{old('LearningRoomCd')}}" class="form-control" required maxlength="6" />
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
                        <x-lsuppo-submit formaction="/hogosha/edit" :mode="'edit'">更新</x-lsuppo-submit>
                        <x-lsuppo-submit formaction="/hogosha/delete" :mode="'delete'">削除</x-lsuppo-submit>
                    </div>
                @elseif($mode=='add')
                    <x-lsuppo-submit formaction="/hogosha/add" :mode="'add'">登録</x-lsuppo-submit>
                @else
                @endif
            </div>
        </form>
        <div id='list'>
            <table class="table table-striped table table-hover table table-responsive">       
                <tr>
                    <th>HogoshaCd</th>
                    <th>Sei</th>
                    <th>Mei</th>
                    <th>Hurigana</th>
                    <th>RiyouKaisiDate</th>
                    <th>RiyouShuuryouDate</th>
                    <th>LearningRoomCd</th>
                    <th>IsLocked</th>
                    <th>IsNeedPWChange</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td><a href="/hogosha/add/?HogoshaCd={{$item->HogoshaCd}}" class="text-indigo-700">{{$item->HogoshaCd}}</a></td>
                    <td>{{$item->Sei}}</td>
                    <td>{{$item->Mei}}</td>
                    <td>{{$item->Hurigana}}</td>
                    <td>{{$item->RiyouKaisiDate}}</td>
                    <td>{{$item->RiyouShuuryouDate}}</td>
                    <td>{{$item->LearningRoomCd}}</td>
                    <td>{{$item->IsLocked}}</td>
                    <td>{{$item->IsNeedPWChange}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    <div>
</div>
@endsection
