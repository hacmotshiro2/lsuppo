<div id="menubarComponent">
<ul>
    @if(@empty($id))
    <li><a href="/fb/">フィードバック</a></li>
    @else
    <li><a href="/fb/{{$id}}">フィードバック</a></li>
    @endif
    @if(@empty($id))
    <li><a href="/lc/">エルコイン</a></li>
    @else
    <li><a href="/lc/{{$id}}">エルコイン</a></li>
    <p>{{$id}}さん</p>
    @endif
</ul>
</div>