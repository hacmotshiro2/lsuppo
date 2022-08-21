
@extends('layouts.lsuppo-base')

@section('title')
フィードバック確認ページ
@endsection
      
@section('content')
@if ($msg !='')
<p> {{$msg}}</p>
@endif

<!-- <table class="tbFb">        -->
<!-- <table class="table table-bordered table table-striped table table-hover table table-responsive">        -->
<div class="mx-4 shadow-xl">
    <table class="border-collapse">
        <tr>
            <th class="border border-slate-300 bg-blue-700 text-slate-50 px-2 py-2">No</th>
            <th class="border border-slate-300 bg-blue-700 text-slate-50 px-2 py-2">タイトル</th>
            <th class="border border-slate-300 bg-blue-700 text-slate-50 px-2 py-2">フィードバック</th>
            <th class="border border-slate-300 bg-blue-700 text-slate-50 px-2 py-2">...</th>
        </tr>
        @foreach($items as $item)
        <tr class="hover:bg-gray-400">
            <td class="border border-slate-700 px-2 py-2"><?=htmlspecialchars($item->FbNo,ENT_QUOTES)?></td>
            <td class="border border-slate-700 px-2 py-2"><?=htmlspecialchars($item->Title,ENT_QUOTES)?></td>
            <td class="border border-slate-700 px-2 py-2"><?=htmlspecialchars(mb_strimwidth($item->Detail,0,30," ... "),ENT_QUOTES)?></td>
            <td class="border border-slate-700 px-2 py-2"><a href=\fb\detail\<?=htmlspecialchars($item->FbNo,ENT_QUOTES)?> >read more...</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection