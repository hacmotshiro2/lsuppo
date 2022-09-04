@extends('layouts.lsuppo-base')

@section('title')
ユーザーとサポーターの紐づけ登録ページ
@endsection
      
@section('content')
        <form method="POST" action="/user2suppo/add" class="row g-2">
            @csrf

            <div class="col-md-6">
                <label for="valuserId" class="form-label">user_id</label>
                <input type="text" id="valuserId" name="user_id" value="{{old('user_id')}}" class="form-control" required></input>
            </div>

            <div class="col-md-6">
                <label for="valSupporterCd" class="form-label">サポーターコード</label>
                <input type="text" id="valSupporterCd" name="SupporterCd" value="{{old('SupporterCd')}}" class="form-control" required maxlength="8"></input>
            </div>
            <div class="col-12">
                <input type="submit" name="create" value="登録" class="bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700" >
            </div>
        </form>
        <div id='list'>
        <table class="table-auto border-collapse border border-slate-500">       
        <tr>
            <th class="border border-slate-600">id</th>
            <th class="border border-slate-600">name</th>
            <th class="border border-slate-600">email</th>
            <th class="border border-slate-600">userType</th>
            <th class="border border-slate-600">StudentName</th>
            <th class="border border-slate-600">user_id</th>
            <th class="border border-slate-600">SupporterCd</th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td class="border border-slate-700">{{$item->id}}</td>
            <td class="border border-slate-700">{{$item->name}}</td>
            <td class="border border-slate-700">{{$item->email}}</td>
            <td class="border border-slate-700">{{$item->userType}}</td>
            <td class="border border-slate-700">{{$item->StudentName}}</td>
            <td class="border border-slate-700">{{$item->user_id}}</td>
            <td class="border border-slate-700">{{$item->SupporterCd}}</td>
        </tr>
        @endforeach
        </table>
        </div>
        <div id='supporterList'>
        <table class="table-auto border-collapse border border-slate-500 my-8">       
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
        @foreach($itemsSupporter as $item)
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