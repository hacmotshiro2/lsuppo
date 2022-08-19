
@extends('layouts.lsuppo-base')

@section('title')
エルコイン確認ページ
@endsection
      
@section('content')
        @if ($msg !='')
        <p> {{$msg}}</p>
        @endif
        <div id=lcZandaka>
            <p>ただいまのエルコイン残高は</p>
            <p>{{$lczandaka}}コインです</p>
        </div>
        <!-- <table class="tbFb">        -->
        <!-- <table class="table table-bordered table table-striped table table-hover table table-responsive">        -->
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>生徒名</th>
            <th>発生日</th>
            <th>コイン数</th>
            <th>事由</th>
            <th>事由補足</th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td><?=htmlspecialchars($item->StudentName,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($item->HasseiDate,ENT_QUOTES)?></td> 
            <td><?=htmlspecialchars($item->amount,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($item->Ziyuu,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars(mb_strimwidth($item->ZiyuuHosoku,0,40," ... "),ENT_QUOTES)?></td>
        </tr>
        @endforeach
        </table>

@endsection