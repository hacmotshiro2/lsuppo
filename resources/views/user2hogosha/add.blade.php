@extends('layouts.lsuppo-base')

@section('title')
ユーザーと保護者の紐づけ登録ページ
@endsection
      
@section('content')
<div class="flex flex-wrap md:flex-nowrap">
    <div>
        @include('components.lsuppo-supermenu')
    </div>
    <div class="ml-4">
        <form method="POST" action="/user2hogosha/add" class="row g-2">
            @csrf
            <div class="my-2">
                <label for="valuserId" class="form-label">user_id</label>
                <x-lsuppo-input type="text" id="valuserId" name="user_id" value="{{old('user_id')}}" class="form-control" required></x-lsuppo-input>
            </div>
            <div class="my-2">
                <label for="valhogoshaCd" class="form-label">保護者コード</label>
                <x-lsuppo-input type="text" id="valhogoshaCd" name="HogoshaCd" value="{{old('HogoshaCd')}}" class="form-control" required maxlength="8"></x-lsuppo-input>
            </div>
            <div class="my-2">
                <x-lsuppo-submit :mode="'add'">登録</x-lsuppo-submit>
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
                    <th class="border border-slate-600">HogoshaCd</th>
                    <th class="border border-slate-600">action</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td class="border border-slate-700">{{$item->id}}</td>
                    <td class="border border-slate-700">{{$item->name}}</td>
                    <td class="border border-slate-700">{{$item->email}}</td>
                    <td class="border border-slate-700">{{$item->userType}}</td>
                    <td class="border border-slate-700">{{$item->StudentName}}</td>
                    <td class="border border-slate-700">{{$item->user_id}}</td>
                    <td class="border border-slate-700">{{$item->HogoshaCd}}</td>
                    <td class="border border-slate-700"><a href="/user2hogosha/delete/?u2h_id={{$item->u2h_id}}"><div class="inline-block items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"> 紐づけ削除</div></td>
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