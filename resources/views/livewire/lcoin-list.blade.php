<div class="w-full mt-6 md:mt-8">
    <span class="text-gray-600 text-lg font-semibold mb-3">エルコイン明細</span>
    <table class="table-fixed">
        <tr>
            <th class="sort bg-gray-300 text-slate-50 p-4" wire:click="sortOrder('StudentCd')">生徒 {!! $sortLink !!}</th>
            <th class="sort bg-gray-300 text-slate-50 p-4" wire:click="sortOrder('HasseiDate')">発生日 {!! $sortLink !!}</th>
            <th class="sort bg-gray-300 text-slate-50 p-4" wire:click="sortOrder('Amount')">コイン数 {!! $sortLink !!}</th>
            <th class="sort bg-gray-300 text-slate-50 p-4" wire:click="sortOrder('ZiyuuCd')">事由 {!! $sortLink !!}</th>
            <th class="bg-gray-300 text-slate-50 p-4" >事由補足</th>
            <th class="sort bg-gray-300 text-slate-50 p-4" wire:click="sortOrder('TourokuSupporterCd')">登録サポーターコード {!! $sortLink !!}</th>
            <th class="sort bg-gray-300 text-slate-50 p-4" wire:click="sortOrder('updated_at')">更新日 {!! $sortLink !!}</th>
            <th class="bg-gray-300 text-slate-50 p-2">欠席情報id</th>
            <th class="bg-gray-300 text-slate-50 p-2">Action</th>
        </tr>
        @foreach($items as $item)
        <tr class="hover:bg-indigo-50 hover:font-bold">
            <td class="px-2 py-2">{{$item->StudentCd}}</td>
            <td class="px-2 py-2">{{$item->HasseiDate}}</td>
            <td class="px-2 py-2">{{$item->Amount}}</td>
            <td class="px-2 py-2">{{$item->ZiyuuCd}}</td>
            <td class="px-2 py-2">{{$item->ZiyuuHosoku}}</td>
            <td class="px-2 py-2">{{$item->TourokuSupporterCd}}</td>
            <td class="px-2 py-2">{{$item->updated_at}}</td>
            <td class="px-2 py-2">{{$item->AbsenceId}}</td>
            <td class="px-2 py-2">
                <button onclick="confirm('id : {{$item->id}} を削除してもよろしいでしょうか？ @if(!empty($item->AbsenceId))※欠席情報が紐づいています@endif') || event.stopImmediatePropagation()" wire:click="delete({{$item->id}})" 
                class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3" >削除</button>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $items->links() }}
</div>
