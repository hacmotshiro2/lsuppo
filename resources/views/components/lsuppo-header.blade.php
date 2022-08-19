<!-- 初期値セット -->
@props(['userName' => 'ななしさん'])

<div id="headerComponent">
<a href="/"><img src="/images/logo-lsuppov1.0-bgw-wide.svg" width="20%"></a>
@unless(@empty($userName))
<!-- userNameにドロップダウンメニューでログアウトなど作りたい -->
<p>{{$userName}}さん</p>
@endunless
</div>