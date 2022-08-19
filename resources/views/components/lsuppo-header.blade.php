<!-- 初期値セット -->
@props(['userName' => 'ななしさん'])

<div id="headerComponent">
<h3><a href="/">エルサポ　マイページ</a></h3>
@unless(@empty($userName))
<!-- userNameにドロップダウンメニューでログアウトなど作りたい -->
<p>{{$userName}}さん</p>
@endunless
</div>