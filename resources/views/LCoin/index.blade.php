
@extends('layouts.lsuppo-base')

@section('title')
エルコイン確認ページ
@endsection
      
@section('content')
        @if ($msg !='')
        <p> {{$msg}}</p>
        @endif
        <div id=lcZandaka>
        <!-- 生徒単位のFOR分 1人の保護者に対して複数の生徒がいることを想定-->
        @for($i=0;$i<count($itemset);$i++)
            <p>ただいまの</p>
            <p><b>{{$itemset[$i][0]->StudentName}}さんの</b></p>
            <p>エルコイン残高は</p>
            <p>{{$lczandakas[$itemset[$i][0]->StudentName]}}コインです</p>
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>発生日</th>
            <th>コイン数</th>
            <th>事由</th>
            <th>事由補足</th>
        </tr>
        <!-- 生徒毎の取引明細の繰り返し -->
        @foreach($itemset[$i] as $item)
        <tr>
            <td><?=htmlspecialchars($item->HasseiDate,ENT_QUOTES)?></td> 
            <td><?=htmlspecialchars($item->amount,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($item->Ziyuu,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars(mb_strimwidth($item->ZiyuuHosoku,0,40," ... "),ENT_QUOTES)?></td>
        </tr>
        @endforeach
        </table>
        @endfor
        </div>

@endsection