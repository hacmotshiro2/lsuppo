<div class="container">
    <div class="my-2 md:my-6">
        <a href="/lc/"><span class="text-indigo-800 text-base sm:text-xl">エルコインを確認 ></span></a>
    </div>
    <div class="relative overflow-x-scroll my-6">
        <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2 mb-4 lg:mb-8" id="StudentCd" name="StudentCd"
        wire:model="selectedSCd">
            @foreach($students as $student)
                <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
            @endforeach
        </select>
        <label class="text-gray-800 text-sm sm:text-base mb-2 md:mb-6">{{$studentName}}さんの欠席・振替状況</label>
        
        <div class="w-full grid grid-cols-2 gap-1 md:gap-2 mb-4">
            @if($rdHurikae=="rdUn")
            <div class="flex items-center pl-4  border-b-2 border-indigo-700">
            @else
            <div class="flex items-center pl-4">
            @endif
                <input id="rd-mihurikae" type="radio" wire:model="rdHurikae" value="rdUn" name="rd-status" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                <label for="rd-mihurikae" class="py-4 ml-2 text-sm md:text-xl font-medium text-gray-900 dark:text-gray-300">未振替 <i class="fa-solid fa-exclamation"></i></label>
                <span class="ml-4 text-sm sm:text-base">{{$countUn}}件</span>
            </div>
            @if($rdHurikae=="rdDone")
            <div class="flex items-center pl-4 border-b-2 border-indigo-700">
            @else
            <div class="flex items-center pl-4 ">
            @endif
                <input checked id="rd-hurizumi" type="radio" wire:model="rdHurikae" value="rdDone" name="rd-status" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="rd-hurizumi" class="py-4 ml-2 text-sm md:text-xl font-medium text-gray-900 dark:text-gray-300">振替済み <i class="fa-regular fa-circle-check"></i> </label>
                <span class="ml-4 text-sm sm:text-base">{{$countDone}}件</span>
            </div>
        </div>

        <!-- 未振替用のテーブル -->
        <div  @if($rdHurikae=="rdUn") style="display:block" @else style="display:none" @endif>
            <table class="table w-full text-left min-w-full shadow-md">
                <thead class="text-xs md:text-base lg:text-lg text-gray-600 bg-gray-50">
                    <tr>
                        <!-- <th class="border border-slate-600 p-4" >振替ステータス</th> -->
                        <!-- <th class="border border-slate-600 p-4" >生徒名</th> -->
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrder('AbsentDate')">欠席した日 {!! $sortLink !!}</th>
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrder('NotifiedDatetime')">欠席連絡日 {!! $sortLink !!}</th>
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrder('ExpirationDate')">振替期限日 {!! $sortLink !!}</th>
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrder('ToYoteiDate')">振替予定日 {!! $sortLink !!}</th>
                        <!-- <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ToActualDate')">振替実績日 {!! $sortLink !!}</th> -->
                        <!-- <th class="border border-slate-600 p-4">エルコイン</th> -->
                        <!-- <th class="border border-slate-600 p-4">識別コード</th> -->
                    </tr>
                </thead>
                <tbody class="text-sm md:text-base lg:text-lg text-gray-700">
                    @foreach($absences_un as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <!-- <td class="border border-slate-700 p-2">{{$item->HurikaeStatus}}</td> -->
                        <!-- <td class="border border-slate-700 p-2">{{$item->student->HyouziMei}}</td> -->
                        <td class="border border-slate-300 p-2">{{$item->AbsentDate}}</td>
                        <td class="border border-slate-300 p-2">{{$item->FormattedNotifiedDatetime}}</td>
                        <td class="border border-slate-300 p-2">{{$item->ExpirationDate}}</td>
                        <td class="border border-slate-300 p-2">{{$item->ToYoteiDate}}</td>
                        <!-- <td class="border border-slate-700 p-2">{{$item->ToActualDate}}</td> -->
                        <!-- <td class="border border-slate-700 p-2">@if(!empty($item->LCMeisaiId))<a href="/lc/">エルコインを確認 </a>@endif</td> -->
                        <!-- <td class="border border-slate-700 p-2">{{$item->id}}</td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-2">
                {{ $absences_un->links() }}
            </div>
            <div class="my-2">
                <label class="text-gray-800 text-sm sm:text-base ">※振替日の連絡等はサポーターに直接お問い合わせください</label>
            </div>
        </div>
        <!-- 振替済み用のテーブル -->
        <div @if($rdHurikae=="rdDone") style="display:block" @else style="display:none" @endif>
            <table class="table w-full text-left min-w-full shadow-md"  >
                <thead class="text-xs md:text-base lg:text-lg text-gray-600 bg-gray-50">
                    <tr>
                        <th class="border border-slate-400 p-4" >振替ステータス</th>
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrderDone('AbsentDate')">欠席した日 {!! $sortLinkDone !!}</th>
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrder('NotifiedDatetime')">欠席連絡日 {!! $sortLink !!}</th>
                        <th class="sort border border-slate-400 p-4" wire:click="sortOrderDone('ToActualDate')">振替先 {!! $sortLinkDone !!}</th>
                        <th class="border border-slate-400 p-4">エルコイン</th>
                    </tr>
                </thead>
                <tbody class="text-sm md:text-base lg:text-lg text-gray-700">
                    @foreach($absences_done as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="border border-slate-300 p-2">{{$item->HurikaeStatusName}}</td>
                        <td class="border border-slate-300 p-2">{{$item->AbsentDate}}</td>
                        <td class="border border-slate-300 p-2">{{$item->FormattedNotifiedDatetime}}</td>
                        <td class="border border-slate-300 p-2">{{$item->ToActualDate}}</td>
                        <td class="border border-slate-300 p-2">@if(!empty($item->LCMeisaiId))<a href="/lc/">エルコインを確認 <i class="fa-solid fa-arrow-up-right-from-square"></i> </a>@endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-2">
                {{ $absences_done->links() }}
            </div>
        </div>
    </div>

</div>