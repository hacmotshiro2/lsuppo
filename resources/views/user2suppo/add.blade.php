@extends('layouts.lsuppo-base')

@section('title')
ユーザーとサポーターの紐づけ登録ページ
@endsection
      
@section('content')
<div class="flex flex-wrap  md:flex-nowrap">
    <div>
        @include('components.lsuppo-supermenu')
    </div>
    <div class="ml-4">
        <form method="POST" action="/user2suppo/add" class="row g-2">
            @csrf

            <div class="my-2">
                <label for="valuserId" class="form-label">user_id</label>
                <x-lsuppo-input type="text" id="valuserId" name="user_id" value="{{old('user_id')}}" class="form-control" required></x-lsuppo-input>
            </div>
            <div class="my-2">
                <label for="valSupporterCd" class="form-label">サポーターコード</label>
                <input type="text" id="valSupporterCd" name="SupporterCd" value="{{old('SupporterCd')}}" class="form-control" required maxlength="8"></input>
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
                    <th class="border border-slate-600">SupporterCd</th>
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
                    <td class="border border-slate-700">{{$item->SupporterCd}}</td>
                    <td class="border border-slate-700"><a href="/user2suppo/delete/?u2s_id={{$item->u2s_id}}"><div class="inline-block items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"> 紐づけ削除</div></td>
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
    </div>
</div>
@endsection