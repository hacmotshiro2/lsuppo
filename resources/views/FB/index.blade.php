
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
        <table class="table table-striped table table-hover table table-responsive">       
        <tr>
            <th>No</th>
            <th>タイトル</th>
            <th>フィードバック</th>
            <th>  </th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td><?=htmlspecialchars($item->FbNo,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($item->Title,ENT_QUOTES)?></td>
            <td><?=htmlspecialchars(mb_strimwidth($item->Detail,0,30," ... "),ENT_QUOTES)?></td>
            <td><a href=\fb\detail\<?=htmlspecialchars($item->FbNo,ENT_QUOTES)?> >read more...</a></td>
        </tr>
        @endforeach
        </table>

@endsection