
@extends('layouts.lsuppo-base')

@section('title')
生徒登録ページ
@endsection
      
@section('content')
        @if(count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="/student/add" class="row g-2">
            @csrf

            <div class="col-md-6">
                <label for="StudentCd" class="form-label">生徒コード</label>
                <input type="text" id="StudentCd" name="StudentCd" value="{{old('StudentCd')}}" class="form-control" required maxlength="8"></input>
            </div>
            <div class="col-md-6">
                <label for="valhogoshaCd" class="form-label">保護者コード</label>
                <input type="text" id="valhogoshaCd" name="HogoshaCd" value="{{old('HogoshaCd')}}" class="form-control" required maxlength="8"></input>
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
                <label for="ScratchID" class="form-label">ScratchID</label>
                <input type="text" id="ScratchID" name="ScratchID" value="{{old('ScratchID')}}" class="form-control" maxlength="20"></input>
            </div>
            <div class="col-md-12">
                <label for="ScratchURL" class="form-label">ScratchURL</label>
                <input type="text" id="ScratchURL" name="ScratchURL" value="{{old('ScratchURL')}}" class="form-control" maxlength="255"></input>
            </div>
            <div class="col-md-6">
                <label for="LearningRoomCd" class="form-label">LRコード</label>
                <select class="form-select" id="LearningRoomCd" name="LearningRoomCd">
                @foreach($lrs as $lr)
                 <option value="{{$lr->LearningRoomCd}}" @if(old('LearningRoomCd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
                @endforeach
                </select>
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
                <input type="submit" name="create" value="登録" class="btn btn-primary" >
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
            <td>{{$item->StudentCd}}</td>
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

@endsection