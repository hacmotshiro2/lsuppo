
@extends('layouts.lsuppo-base')

@section('title')
フィードバック詳細確認ページ
@endsection
      
@section('content')

    @if(isset($item))
    <p>生徒コード：<?=htmlspecialchars($item->StudentCd,ENT_QUOTES)?></p>
    <table class="table table-responsive">
        <tr>
            <th>タイトル</th>
            <td><?=htmlspecialchars($item->Title,ENT_QUOTES)?></td>
        </tr>
        <tr>
            <th>フィードバック</th>
            <td><?=nl2br(htmlspecialchars($item->Detail,ENT_QUOTES))?></td>
        </tr>
        <tr>
            <th>フィードバック記入者</th>
            <td><?=htmlspecialchars($item->KinyuuSupporterCd,ENT_QUOTES)?></td>
        </tr>
    </table>
    @else
    <p>ページ遷移が不正です</p>
    @endif
    <p><a href='\fb\'>&lt;戻る</a></p>

@endsection