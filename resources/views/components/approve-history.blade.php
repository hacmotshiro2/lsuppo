<!-- サブビューとして使う想定 -->
@if(!is_null($lah))
<div class="w-full mt-6 md:mt-8">
    <span class="text-gray-800 text-lg font-semibold mb-3">承認履歴</span>
    <table class="table-fixed">
    <tr class="text-sm">
        <th class="bg-slate-100 text-gray-500 px-2 py-2">発生日</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">サポーター</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">承認ステータス</th>
        <th class="bg-slate-100 text-gray-500 px-2 py-2">コメント</th>
    </tr>
    @foreach($lah as $item)
    <!-- <tr class="hover:bg-gray-400"> -->
    <tr class="text-xs">
        <td class="px-2 py-2">{{$item->HasseiDate}}</td>
        <td class="px-2 py-2">{{$item->getSupporterCdName()}}</td>
        <td class="px-2 py-2">{{$item->getShouninStatusCdName()}}</td>
        <td class="px-2 py-2">{{$item->Comment}}</td>
    </tr>
    @endforeach
    </table>
</div>
@endif