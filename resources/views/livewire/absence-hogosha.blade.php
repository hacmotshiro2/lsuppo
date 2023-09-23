<div class="container">
  <div class="relative overflow-x-scroll my-6">
    <select class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2 mb-4 lg:mb-8" id="StudentCd" name="StudentCd"
     wire:model="selectedSCd">
        @foreach($students as $student)
            <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
        @endforeach
    </select>
    <label class="text-gray-800 text-sm sm:text-base mb-2 md:mb-6">{{$studentName}}さんの欠席・振替状況</label>
    
    <div class="w-full grid grid-cols-2 gap-1 md:gap-2">
        <div class="flex items-center pl-4 ">
            <input id="rd-mihurikae" type="radio" wire:model="rdHurikae" value="rdUn" name="rd-status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="rd-mihurikae" class="w-full py-4 ml-2 text-sm md:text-xl font-medium text-gray-900 dark:text-gray-300">未振替</label>
        </div>
        <div class="flex items-center pl-4 ">
            <input checked id="rd-hurizumi" type="radio" wire:model="rdHurikae" value="rdDone" name="rd-status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="rd-hurizumi" class="w-full py-4 ml-2 text-sm md:text-xl font-medium text-gray-900 dark:text-gray-300">振替済み</label>
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
                    <!-- <th class="sort border border-slate-600 p-4" wire:click="sortOrder('NotifiedDatetime')">欠席連絡をいただいた日 {!! $sortLink !!}</th> -->
                    <th class="sort border border-slate-400 p-4" wire:click="sortOrder('ExpirationDate')">振替期限日 {!! $sortLink !!}</th>
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ToYoteiDate')">振替予定日 {!! $sortLink !!}</th>
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
                    <!-- <td class="border border-slate-700 p-2">{{$item->FormattedNotifiedDatetime}}</td> -->
                    <td class="border border-slate-300 p-2">{{$item->ExpirationDate}}</td>
                    <td class="border border-slate-700 p-2">{{$item->ToYoteiDate}}</td>
                    <!-- <td class="border border-slate-700 p-2">{{$item->ToActualDate}}</td> -->
                    <!-- <td class="border border-slate-700 p-2">@if(!empty($item->LCMeisaiId))<a href="/lc/">エルコインを確認 </a>@endif</td> -->
                    <!-- <td class="border border-slate-700 p-2">{{$item->id}}</td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $absences_un->links() }}
    </div>
    <!-- 振替済み用のテーブル -->
    <div @if($rdHurikae=="rdDone") style="display:block" @else style="display:none" @endif>
        <table class="table w-full text-left min-w-full shadow-md"  >
            <thead class="text-xs md:text-base lg:text-lg text-gray-600 bg-gray-50">
                <tr>
                    <th class="border border-slate-600 p-4" >振替ステータス</th>
                    <!-- <th class="border border-slate-600 p-4" >生徒名</th> -->
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('AbsentDate')">欠席した日 {!! $sortLink !!}</th>
                    <!-- <th class="sort border border-slate-600 p-4" wire:click="sortOrder('NotifiedDatetime')">欠席連絡をいただいた日 {!! $sortLink !!}</th> -->
                    <!-- <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ExpirationDate')">振替期限日 {!! $sortLink !!}</th> -->
                    <!-- <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ToYoteiDate')">振替予定日 {!! $sortLink !!}</th> -->
                    <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ToActualDate')">振替先 {!! $sortLink !!}</th>
                    <th class="border border-slate-600 p-4">エルコイン</th>
                    <!-- <th class="border border-slate-600 p-4">識別コード</th> -->
                </tr>
            </thead>
            <tbody class="text-sm md:text-base lg:text-lg text-gray-700">
                @foreach($absences_done as $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="border border-slate-700 p-2">{{$item->HurikaeStatusName}}</td>
                    <!-- <td class="border border-slate-700 p-2">{{$item->student->HyouziMei}}</td> -->
                    <td class="border border-slate-700 p-2">{{$item->AbsentDate}}</td>
                    <!-- <td class="border border-slate-700 p-2">{{$item->FormattedNotifiedDatetime}}</td> -->
                    <!-- <td class="border border-slate-700 p-2">{{$item->ExpirationDate}}</td> -->
                    <!-- <td class="border border-slate-700 p-2">{{$item->ToYoteiDate}}</td> -->
                    <td class="border border-slate-700 p-2">{{$item->ToActualDate}}</td>
                    <td class="border border-slate-700 p-2">@if(!empty($item->LCMeisaiId))<a href="/lc/">エルコインを確認 </a>@endif</td>
                    <!-- <td class="border border-slate-700 p-2">{{$item->id}}</td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $absences_done->links() }}
    </div>
    </div>
</div>