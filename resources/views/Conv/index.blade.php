@extends('layouts.lsuppo-base')

@section('title')
CLOVA会話一覧
@endsection

@section('content')
<div class="w-full mt-6 md:mt-8">
    <span class="text-gray-800 text-lg font-semibold mb-3">アップロードファイル一覧</span>
    <table class="table-fixed">
    <tr class="text-sm">
        <th class="bg-slate-100 text-gray-500 px-2 py-2">id</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">セッション日</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">ファイル名</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">アップロード日</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">LR</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">コメント</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">.</th>
    </tr>
    @foreach($lConvH as $item)
    <tr class="text-base">
        <td class="px-2 py-2">{{$item->id}}</td>
        <td class="px-2 py-2">{{$item->SessionDate}}</td>
        <td class="px-2 py-2">{{$item->FileName}}</td>
        <td class="px-2 py-2">{{$item->UploadedDatetime}}</td>
        <td class="px-2 py-2">{{$item->LearningRoomCd}}</td>
        <td class="px-2 py-2">{{$item->Comment}}</td>
        <td class="px-2 py-2"><a class="text-indigo-500 items-center" href="\conv\detail\?headerId={{$item->id}}">詳細</a></td>
    </tr>
    @endforeach
    </table>
</div>
@endsection
