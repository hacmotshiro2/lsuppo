<div class="container">
    <div class="relative overflow-x-scroll shadow-md">
        <!-- LearningRoom選択 -->
        <select class="w-full md:w-1/2 bg-gray-50 text-gray-800 border focus:ring focus:ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2 mb-4 lg:mb-8" 
        name="lrcd" wire:model="selectedLRCd">
            @foreach($lrs as $lr)
                <option value="{{$lr->LearningRoomCd}}" @if(old('lrcd')==$lr->LearningRoomCd) selected @endif >{{$lr->getCdName()}}</option>
            @endforeach
        </select>
        <!-- List -->
        <table class="table w-full text-sm text-left text-gray-600 min-w-full">
            <thead class="text-xs text-gray-700 bg-gray-100">
                <tr>
                    <th class="sort border border-slate-600 p-4" >Action</th>
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('FbNo')">FbNo {!! $sortLink !!}</th>
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('StudentCd')">生徒コード {!! $sortLink !!}</th>
                    <th class="border border-slate-600 p-4" >生徒名</th>
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('TaishoukikanFrom')">対象期間 {!! $sortLink !!}</th>
                    <th class="border border-slate-600 p-4" >タイトル</th>
                    <th class="border border-slate-600 p-4" >詳細</th>
                    <th class="border border-slate-600 p-4" >記入サポーター</th>
                    <th class="border border-slate-600 p-4" >承認ステータス</th>
                    <th class="border border-slate-600 p-4" >初回閲覧日</th>
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('created_at')">created_at {!! $sortLink !!}</th>
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('updated_at')">updated_at {!! $sortLink !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                @if($item->ShouninStatus != 5) 
                <!-- 承認済みでなければ色を変える -->
                <tr class="bg-indigo-100 border-b hover:bg-indigo-300">
                @else
                <tr class="bg-white border-b hover:bg-gray-50">
                @endif
                    <td class="border border-slate-700 p-2">
                        <a class="mx-auto" href="/fb/detail?fbNo={{$item->FbNo}}">
                            <div class="p-2 border rounded-md border-indigo-700 hover:noborder hover:bg-indigo-700 hover:text-white justify-center ">
                                <span class="mx-auto">詳細</span>
                            </div>
                        </a>
                    </td>
                    <td class="border border-slate-700 p-2">{{$item->FbNo}}</td>
                    <td class="border border-slate-700 p-2">{{$item->StudentCd}}</td>
                    <td class="border border-slate-700 p-2">{{$item->student->HyouziMei}}</td>
                    <td class="border border-slate-700 p-2">{{$item->TaishoukikanStr}}</td>
                    <td class="border border-slate-700 p-2">{{mb_strimwidth($item->Title,0,20)}}</td>
                    <td class="border border-slate-700 p-2">{{mb_strimwidth($item->Detail,0,20)}}</td>
                    <td class="border border-slate-700 p-2">{{$item->kinyuuSupporter->HyouziMei}}</td>
                    <td class="border border-slate-700 p-2">{{$item->ShouninStatusName}}</td>
                    <td class="border border-slate-700 p-2">{{$item->FirstReadDate}}</td>
                    <td class="border border-slate-700 p-2">{{$item->created_at}}</td>
                    <td class="border border-slate-700 p-2">{{$item->updated_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <p class="text-gray-600 text-sm my-4">※<span class="text-indigo-700">紺色</span>の行は未承認</p>
    </div>
</div>