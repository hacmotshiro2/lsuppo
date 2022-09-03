
@extends('layouts.lsuppo-base')

@section('title')
サポーター登録ページ
@endsection
      
@section('content')
        <form method="POST" action="/supporter/add/" class="">
            @csrf

            <div class="col-md-6">
                <label for="valSupporterCd" class="form-label">サポーターコード</label>
                <input type="text" id="valSupporterCd" name="SupporterCd" value="{{old('SupporterCd')}}" class="form-control" required maxlength="8"></input>
            </div>
            <div class="col-md-4">
                <label for="valSei" class="form-label">姓</label>
                <input type="text" id="valSei" name="Sei" value="{{old('Sei')}}" class="form-control" required></input>
            </div>
            <div class="col-md-4">
                <label for="valMei" class="form-label">名</label>
                <input type="text" id="valMei" name="Mei" value="{{old('Mei')}}" class="form-control" required></input>
            </div>
            <div class="col-md-4">
                <label for="valHurigana" class="form-label">フリガナ</label>
                <input type="text" id="valHurigana" name="Hurigana" value="{{old('Hurigana')}}" class="form-control" required></input>
            </div>
            <div class="col-md-6">
                <label for="valHyouziMei" class="form-label">表示名</label>
                <input type="text" id="valHyouziMei" name="HyouziMei" value="{{old('HyouziMei')}}" class="form-control" required></input>
            </div>
            <div class="col-md-6">
                <label for="valLearningRoomCd" class="form-label">LRコード</label>
                <input type="text" id="valLearningRoomCd" name="LearningRoomCd" value="{{old('LearningRoomCd')}}" class="form-control" required maxlength="6"></input>
            </div>
            <div class="col-md-6">
                <label class="form-label">権限レベル</label>
                <input type="text"  name="authlevel" value="{{old('authlevel')}}" class="form-control" required maxlength="1"></input>
            </div>
            <div class="col-md-6">
                <label for="valRiyouFrom" class="form-label">利用期間</label>
                <div class="input-group">
                    <input type="date" id="valRiyouFrom" name="RiyouKaisiDate" class="form-control"></input>
                    <span class="input-group-text" id="inputGroupbar"> ～</span>
                    <input type="date" id="valRiyouFrom" name="RiyouShuuryouDate" class="form-control"></input>    
                </div>
            </div>
            <div class="col-md-3">
            <!-- <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> 参考-->
                <input type="checkbox" id="valLocked" name="IsLocked[]" value="{{old('IsLocked')=='1'?'checked':''}}"  >
                <label for="valLocked" class="form-label">ロックされている</label>
            </div>       
            <div class="col-md-3">
                <input type="checkbox" id="valIsNeedPWChange" name="IsNeedPWChange[]" value="{{old('IsNeedPWChange')=='1'?'checked':''}}"></input>
                <label for="valIsNeedPWChange" class="form-label">パスワード変更が必要</label>
            </div>
            <div class="col-12">
                <input type="submit" name="create" value="登録" class="bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700" >
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
            <td class="border border-slate-700">{{$item->SupporterCd}}</td>
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

@endsection