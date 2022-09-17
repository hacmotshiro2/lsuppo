
@extends('layouts.lsuppo-base')

@section('title')
生徒登録ページ
@endsection
      
@section('content')
<div class="flex flex-wrap md:flex-nowrap">
    <div>
        @include('components.lsuppo-supermenu')
    </div>
    <div class="ml-4">
        <form method="POST" action="/student/add" class="row g-2">
            @csrf
            <div class="mb-2">
                <label for="StudentCd" class="form-label">生徒コード</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="StudentCd" name="StudentCd" value="{{$item->StudentCd}}" class="form-control bg-gray-200" required maxlength="8" readonly />
                @else
                    <x-lsuppo-input type="text" id="StudentCd" name="StudentCd" value="{{old('StudentCd')}}" class="bg-white" required maxlength="8" />
                @endif
            </div>
            <div class="mb-2">
                <label for="valhogoshaCd" class="form-label">保護者コード</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valhogoshaCd" name="HogoshaCd" value="{{$item->HogoshaCd}}" class="form-control bg-gray-200" required maxlength="8" />
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
            <div class="col-md-6">
                <label for="valHyouziMei" class="form-label">表示名</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="valHyouziMei" name="HyouziMei" value="{{$item->HyouziMei}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="valHyouziMei" name="HyouziMei" value="{{old('HyouziMei')}}" class="form-control" required />
                @endif
            </div>
            <div class="col-md-6">
                <label for="ScratchID" class="form-label">ScratchID</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="ScratchID" name="ScratchID" value="{{$item->ScratchID}}" class="form-control" required />
                @else
                    <x-lsuppo-input type="text" id="ScratchID" name="ScratchID" value="{{old('ScratchID')}}" class="form-control" required />
                @endif
            </div>
            <div class="col-md-12">
                <label for="ScratchURL" class="form-label">ScratchURL</label>
                @if($mode=='edit')
                    <x-lsuppo-input type="text" id="ScratchURL" name="ScratchURL" value="{{$item->ScratchURL}}" class="form-control" required maxlength="255"/>
                @else
                    <x-lsuppo-input type="text" id="ScratchURL" name="ScratchURL" value="{{old('ScratchURL')}}" class="form-control" required maxlength="255"/>
                @endif
            </div>
            <div class="col-md-6">
                <label for="LearningRoomCd" class="form-label">LRコード</label>
                <select class="form-select" id="LearningRoomCd" name="LearningRoomCd">
                @foreach($lrs as $lr)
                 <option value="{{$lr->LearningRoomCd}}" @if(old('LearningRoomCd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                @endforeach
                </select>
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
                        <x-lsuppo-submit formaction="/student/edit" :mode="'edit'">更新</x-lsuppo-submit>
                        <x-lsuppo-submit formaction="/student/delete" :mode="'delete'">削除</x-lsuppo-submit>
                    </div>
                @elseif($mode=='add')
                    <x-lsuppo-submit formaction="/student/add" :mode="'add'">登録</x-lsuppo-submit>
                @else
                @endif
            </div>
        </form>
        <div id='list'>
            <table class="table table-striped table table-hover table table-responsive">       
                <tr>
                    <th>StudentCd</th>
                    <th>Sei</th>
                    <th>Mei</th>
                    <th>Hurigana</th>
                    <th>HyouziMei</th>
                    <th>PW</th>
                    <th>HogoshaCd</th>
                    <th>ScratchID</th>
                    <th>ScratchURL</th>
                    <th>RiyouKaisiDate</th>
                    <th>RiyouShuuryouDate</th>
                    <th>LearningRoomCd</th>
                    <th>IsLocked</th>
                    <th>IsNeedPWChange</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td><a href="/student/add/?StudentCd={{$item->StudentCd}}" class="text-indigo-700">{{$item->StudentCd}}</a></td>
                    <td>{{$item->Sei}}</td>
                    <td>{{$item->Mei}}</td>
                    <td>{{$item->Hurigana}}</td>
                    <td>{{$item->HyouziMei}}</td>
                    <td>{{$item->PW}}</td>
                    <td>{{$item->HogoshaCd}}</td>
                    <td>{{$item->ScratchID}}</td>
                    <td>{{$item->ScratchURL}}</td>
                    <td>{{$item->RiyouKaisiDate}}</td>
                    <td>{{$item->RiyouShuuryouDate}}</td>
                    <td>{{$item->LearningRoomCd}}</td>
                    <td>{{$item->IsLocked}}</td>
                    <td>{{$item->IsNeedPWChange}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection