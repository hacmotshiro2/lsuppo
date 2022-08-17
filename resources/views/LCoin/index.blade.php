
@extends('layouts.lsuppo-base')

@section('title')
エルコイン確認ページ
@endsection
      
@section('content')
        <p>ID: {{$id}}</p>
        @if ($msg !='')
        <p> {{$msg}}</p>
        @endif
        <div id=lcZandaka>
            <p>ただいまの残高は</p>
            <p>{{$lczandaka}}</p>
        </div>
        <!-- <table class="tbFb">        -->
        <!-- <table class="table table-bordered table table-striped table table-hover table table-responsive">        -->
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>発生日</th>
            <th>コイン数</th>
            <th>事由</th>
            <th>事由補足</th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td><?=htmlspecialchars($item->HasseiDate,ENT_QUOTES)?></td> 
            <td><?=htmlspecialchars($item->amount,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($item->ZiyuuCd,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars(mb_strimwidth($item->ZiyuuHosoku,0,40," ... "),ENT_QUOTES)?></td>
        </tr>
        @endforeach
        </table>

@endsection