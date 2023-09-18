<div class="container">
  <div class="relative overflow-x-scroll shadow-md rounded-lg ">
    <table class="table w-full text-sm text-left text-gray-600 min-w-full">
        <thead class="text-xs text-gray-700 bg-gray-50">
            <tr>
                <th class="sort border border-slate-600 p-4" >--操作--</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('id')">id {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('StudentCd')">StudentCd {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4" >StudentName</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('AbsentDate')">AbsentDate {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('NotifiedDatetime')">NotifiedDatetime {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ToYoteiDate')">ToYoteiDate {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ToActualDate')">ToActualDate {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ExpirationDate')">ExpirationDate {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('LCZiyuuCd')">LCZiyuuCd {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4" >LCZiyuuHosoku</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('LCYoteiAmountImm')">LCYoteiAmountImm {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('LCYoteiAmountExp')">LCYoteiAmountExp {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('LCSwappedDatetime')">LCSwappedDatetime {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('LCMeisaiId')">LCMeisaiId {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('TourokuSupporterCd')">TourokuSupporterCd {!! $sortLink !!}</th>
                <th class="border border-slate-600 p-4" >TourokuSupporterName</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('created_at')">created_at {!! $sortLink !!}</th>
                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('updated_at')">updated_at {!! $sortLink !!}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absences as $item)
            <tr class="bg-white border-b hover:bg-gray-50">
                <!-- <td class="border border-slate-700 p-2"><a href="/absence/add?id={{$item->id}}"><input type="button" class="border border-indigo-700 p-2">編集</input></a></td> -->
                <td class="border border-slate-700 p-2"><a href="/absence/add?id={{$item->id}}"><div class="p-6 border rounded-md border-indigo-700 hover:noborder hover:bg-indigo-700 hover:text-white"><span class="">編集</span><div></a></td>
                <td class="border border-slate-700 p-2">{{$item->id}}</td>
                <td class="border border-slate-700 p-2">{{$item->StudentCd}}</td>
                <td class="border border-slate-700 p-2">{{$item->student->HyouziMei}}</td>
                <td class="border border-slate-700 p-2">{{$item->AbsentDate}}</td>
                <td class="border border-slate-700 p-2">{{$item->NotifiedDatetime}}</td>
                <td class="border border-slate-700 p-2">{{$item->ToYoteiDate}}</td>
                <td class="border border-slate-700 p-2">{{$item->ToActualDate}}</td>
                <td class="border border-slate-700 p-2">{{$item->ExpirationDate}}</td>
                <td class="border border-slate-700 p-2">{{$item->LCZiyuuCd}}</td>
                <td class="border border-slate-700 p-2">{{$item->LCZiyuuHosoku}}</td>
                <td class="border border-slate-700 p-2">{{$item->LCYoteiAmountImm}}</td>
                <td class="border border-slate-700 p-2">{{$item->LCYoteiAmountExp}}</td>
                <td class="border border-slate-700 p-2">{{$item->LCSwappedDatetime}}</td>
                <td class="border border-slate-700 p-2">{{$item->LCMeisaiId}}</td>
                <td class="border border-slate-700 p-2">{{$item->TourokuSupporterCd}}</td>
                <td class="border border-slate-700 p-2">{{$item->supporter->HyouziMei}}</td>
                <td class="border border-slate-700 p-2">{{$item->created_at}}</td>
                <td class="border border-slate-700 p-2">{{$item->updated_at}}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
    {{ $absences->links() }}
  </div>
</div>