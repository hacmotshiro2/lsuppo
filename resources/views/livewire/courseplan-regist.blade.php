<div>
    <div class="container">
        <form method="POST" action="/cp/add" class="row g-2" >
            @csrf
            <div class="flex-col md:grid md:grid-cols-3 md:gap-4 md:auto-cols-fr" >
                <!-- 生徒コード -->
                <label for="StudentCd" class="text-gray-800 text-sm sm:text-base mb-2">生徒コード*</label>
                <select class="w-full md:w-2/3 md:col-span-2 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
                id="StudentCd" name="StudentCd" wire:model="selectedSCd">
                    <!-- 空白行入れる -->
                        <option value="" >----</option>
                    @foreach($students as $student)
                        <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
                    @endforeach
                </select>
                <!-- 適用開始日 -->
                <div>
                    <label for="ApplicationDate" class="text-gray-800 text-sm sm:text-base mb-2">適用開始日*</label>
                    <p class="text-gray-600 text-xs sm:text-sm mb-2">月初日を指定してください</p>
                </div>
                <input type="date" name="ApplicationDate" class="w-full md:w-2/3 md:col-span-2 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2" 
                value="{{old('ApplicationDate')}}" ></input>
                <!-- コースコード -->
                <label for="CourseCd" class="text-gray-800 text-sm sm:text-base mb-2">コース</label>
                <div class="w-full md:col-span-2">
                    @foreach($courses as $course)
                    <div>
                        <input id="rd-{{$course->Code}}" type="radio" value="{{$course->Code}}" name="CourseCd" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                        <label for="rd-{{$course->Code}}" class="py-4 ml-2 text-sm md:text-xl font-medium text-gray-900 dark:text-gray-300">{{$course->Value}}</label>
                    </div>
                    @endforeach
                </div>
                <!-- プランコード -->
                <label for="PlanCd" class="text-gray-800 text-sm sm:text-base mb-2">プラン</label>
                <div class="w-full md:col-span-2">
                    @foreach($plans as $plan)
                    <div>
                        <input id="rd-{{$plan->Code}}" type="radio" value="{{$plan->Code}}" name="PlanCd" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                        <label for="rd-{{$plan->Code}}" class="py-4 ml-2 text-sm md:text-xl font-medium text-gray-900 dark:text-gray-300">{{$plan->Value}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- 生徒ごとの登録履歴表示 -->
            <div class="my-8">
                <div class="relative overflow-x-scroll shadow-md ">
                    <table class="table w-full text-sm text-left text-gray-600 min-w-full">
                        <thead class="text-xs text-gray-700 bg-gray-100">
                            <tr>
                                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('id')">id {!! $sortLink !!}</th>
                                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('StudentCd')">生徒コード {!! $sortLink !!}</th>
                                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('ApplicationDate')">適用開始日 {!! $sortLink !!}</th>
                                <th class="border border-slate-600 p-4" >コース</th>
                                <th class="border border-slate-600 p-4" >プラン</th>
                                <th class="sort border border-slate-600 p-4" wire:click="sortOrder('created_at')">created_at {!! $sortLink !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courseplans as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="border border-slate-700 p-2">{{$item->id}}</td>
                                <td class="border border-slate-700 p-2">{{$item->StudentCd}}</td>
                                <td class="border border-slate-700 p-2">{{$item->ApplicationDate}}</td>
                                <td class="border border-slate-700 p-2">{{$item->CourseCd."-".$item->course->Value}}</td>
                                <td class="border border-slate-700 p-2">{{$item->PlanCd."-".$item->plan->Value}}</td>
                                <td class="border border-slate-700 p-2">{{$item->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{ $courseplans->links() }}
                </div>                
            </div>
            <div class="my-4">
                <!-- ID情報など -->
                <!-- 登録ボタン -->
                <x-lsuppo-submit formaction="/cp/add" :mode="'add'" >登録</x-lsuppo-submit>
            </div>
        </form>
    </div>
</div>
