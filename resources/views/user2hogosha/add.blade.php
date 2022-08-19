@extends('layouts.lsuppo-base')

@section('title')
ユーザーと保護者の紐づけ登録ページ
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
        <form method="POST" action="/user2hogosha/add/" class="row g-2">
            @csrf

            <div class="col-md-6">
                <label for="valuserId" class="form-label">user_id</label>
                <input type="text" id="valuserId" name="user_id" value="{{old('user_id')}}" class="form-control" required></input>
                <div class="valid-feedback">
                good!
                </div>
            </div>

            <div class="col-md-6">
                <label for="valhogoshaCd" class="form-label">保護者コード</label>
                <input type="text" id="valhogoshaCd" name="HogoshaCd" value="{{old('HogoshaCd')}}" class="form-control" required maxlength="8"></input>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-12">
                <input type="submit" name="create" value="登録" class="btn btn-primary" >
            </div>
        </form>
        <div id='list'>
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>userType</th>
            <th>StudentName</th>
            <th>user_id</th>
            <th>HogoshaCd</th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->userType}}</td>
            <td>{{$item->StudentName}}</td>
            <td>{{$item->user_id}}</td>
            <td>{{$item->HogoshaCd}}</td>
        </tr>
        @endforeach
        </table>
        </div>
        <div id='hogoshaList'>
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>HogoshaCd</th>
            <th>Sei</th>
            <th>Mei</th>
            <th>Hurigana</th>
            <th>HyouziMei</th>
            <th>PW</th>
            <th>RiyouKaisiDate</th>
            <th>RiyouShuuryouDate</th>
            <th>LearningRoomCd</th>
            <th>IsLocked</th>
            <th>IsNeedPWChange</th>
        </tr>
        @foreach($itemsHogosha as $item)
        <tr>
            <td>{{$item->HogoshaCd}}</td>
            <td>{{$item->Sei}}</td>
            <td>{{$item->Mei}}</td>
            <td>{{$item->Hurigana}}</td>
            <td>{{$item->HyouziMei}}</td>
            <td>{{$item->PW}}</td>
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