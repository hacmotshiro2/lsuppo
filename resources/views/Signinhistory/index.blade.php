@extends('layouts.lsuppo-base')

@section('title')
サインイン履歴一覧
@endsection

@section('content')
<div class="w-full mt-6 md:mt-8">
    <span class="text-gray-800 text-lg font-semibold mb-3">サインイン履歴一覧</span>
    <table class="table-fixed">
    <tr class="text-sm">
        <th class="bg-slate-100 text-gray-500 px-2 py-2">id</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">user_id</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">user_name</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">サインイン日</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">IPアドレス</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">user_agent</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">os</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">device</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">browser</th>
    </tr>
    @foreach($items as $item)
    <tr class="text-base">
        <td class="px-2 py-2">{{$item->id}}</td>
        <td class="px-2 py-2">{{$item->user_id}}</td>
        <td class="px-2 py-2">{{$item->name}}</td>
        <td class="px-2 py-2">{{$item->signin_datetime}}</td>
        <td class="px-2 py-2">{{$item->ip}}</td>
        <td class="px-2 py-2">{{mb_strimwidth($item->user_agent,0,60,' ...')}}</td>
        <td class="px-2 py-2">{{$item->os}}</td>
        <td class="px-2 py-2">{{$item->device}}</td>
        <td class="px-2 py-2">{{$item->browser}}</td>
    </tr>
    @endforeach
    </table>
</div>
@endsection
