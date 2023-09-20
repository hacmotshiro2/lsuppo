<div class="">
    <div class="container">
        <div class="relative overflow-x-scroll shadow-md rounded-lg ">
            <p class="text-gray-800 text-sm sm:text-base">欠席情報一覧<p>
            <table class="table w-full text-sm text-left text-gray-600 min-w-full">
                <thead class="text-xs text-gray-700 bg-gray-50">
                    <tr>
                        <th class="border border-slate-600 p-4" >Action</th>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($absences as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="border border-slate-700 p-2"><button wire:click="selectAb({{$item->id}})" class="px-4 border rounded-md border-indigo-700 hover:noborder hover:bg-indigo-700 hover:text-white"><span class="whitespace-nowrap">選択</span></button></td>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $absences->links() }}
        </div>
        <div class="my-4">
            <span class="text-gray-800 text-base sm:text-xl" >選択中の欠席情報id : {{$selected_id}} </span>
            <button wire:click="selectAb(0)" class="px-4 border rounded-md border-red-700 hover:noborder hover:bg-red-700 hover:text-white">クリア</button>
        </div>
    </div>

    <form method="POST" action="/lc/add" class="row g-2" >
        @csrf
        <div class="flex-col md:grid md:grid-cols-3 md:gap-4 md:auto-cols-fr" >
            <!-- 生徒コード -->
            <label for="StudentCd" class="text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
            <select class="w-full md:w-2/3 md:col-span-2 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            id="StudentCd" name="StudentCd" @if($isReadOnly) disabled @endif >
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($students as $student)
                    <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
                @endforeach
            @elseif($mode=='edit')
                    <option value="{{$students[0]->StudentCd}}" selected readonly>{{$students[0]->getCdName()}}</option>
            @endif
            </select>
            <!-- 発生日 -->
            <label for="HasseiDate" class="text-gray-800 text-sm sm:text-base mb-2">発生日*</label>
            <input type="date" name="HasseiDate" class=" md:col-span-2 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            value="@if($mode=='add'){{old('HasseiDate')}}@elseif($mode=='edit'){{$form->HasseiDate}}@endif" @if($isReadOnly) readonly @endif ></input>
            <!-- 事由コード -->
            <label for="ZiyuuCd" class="text-gray-800 text-sm sm:text-base mb-2">事由</label>
            <select class="w-2/3  md:col-span-2 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
            id="ZiyuuCd" name="ZiyuuCd" @if($isReadOnly) disabled @endif >
            @if($mode=='add')
                <!-- 空白行入れる -->
                    <option value="" >----</option>
                @foreach($ziyuus as $ziyuu)
                    <option value="{{$ziyuu->ZiyuuCd}}" @if(old('ZiyuuCd')==$ziyuu->ZiyuuCd) selected @endif data-da="{{$ziyuu->DefaultAmount}}">{{$ziyuu->getCdName()}} {{$ziyuu->DefaultAmount}}</option>
                @endforeach
            @elseif($mode=='edit')
            @endif
            </select>
            <!-- コイン数量 -->
            <label for="Amount" class="inline-block text-gray-800 text-sm sm:text-base mb-2">コイン数量　</BR>※減額の場合はマイナスで入力</label>
            <x-lsuppo-input type="number" id="txtAmount" name="Amount" value="{{old('Amount')}}" class=" md:col-span-2 "></x-lsuppo-input>
            <!-- 事由補足 -->
            <label for="ZiyuuHosoku" class="inline-block text-gray-800 text-sm sm:text-base mb-2">事由補足　</BR>※デフォルトから数量を変更する場合はその旨も記載</label>
            <input type="text" class="w-full  md:col-span-2 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"  name="ZiyuuHosoku" 
            value="@if($mode=='add'){{old('ZiyuuHosoku')}} @elseif($mode=='edit'){{$form->ZiyuuHosoku}} @endif" @if($isReadOnly) readonly @endif />
            <!-- 登録サポーター -->
            <label for="TourokuSupporterCd" class="inline-block text-gray-800 text-sm sm:text-base mb-2">登録サポーターコード</label>
            <input type="text" name="TourokuSupporterCd" value="{{$TourokuSupporterCd}}" class="w-full  md:col-span-2 bg-gray-100 text-gray-800 border rounded outline-none px-3 py-2" readonly></input>
        </div>
        <div class="my-4">
            <!-- ID情報など -->
            <input type="hidden" name="AbsenceId" wire:model="selected_id">
            <!-- 登録ボタン -->
            @if($isReadOnly)
                <x-lsuppo-submit formaction="/lc/add" :mode="'add'" disabled>登録</x-lsuppo-submit>
            @else
                <x-lsuppo-submit formaction="/lc/add" :mode="'add'" >登録</x-lsuppo-submit>
            @endif
        </div>
    </form>
</div>
