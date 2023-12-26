<div>
  <div class="bg-white text-center">
      <div class="px-8 mx-auto">
        <select title="生徒コード" class="w-full sm:w-96 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 py-2 mb-4 lg:mb-8" id="StudentCd" name="StudentCd"
            wire:model.live="selectedSCd">
            @foreach($students as $student)
                <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
            @endforeach
        </select>
      </div>
  </div>
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-xl px-4 md:px-8">
      @if($noitem == 1)
      <div class="py-2 text-center  lg:text-lg font-semibold uppercase tracking-widest text-gray-700">まだ表示できる情報が登録されていません。</div>
      @else
      <div class="mb-6 grid gap-6 sm:grid-cols-2 md:mb-8 lg:grid-cols-4 lg:gap-8">
        <!-- 選択中のplan - start -->
        <div class="flex flex-col overflow-hidden rounded-lg border-2 border-indigo-500">
          <div class="bg-indigo-500 py-2 text-center text-sm font-semibold uppercase tracking-widest text-white">現在のコースプラン</div>
          <div class="flex flex-1 flex-col p-4 pt-6 sm:p-6 sm:pt-8">
            <div class="flex sm:block sm:mb-12">
              <div class="mb-2 text-center text-2xl font-bold text-gray-700">{{$cps[0]->CourseName}}</div>
              <div class="inline-block sm:hidden">・</div>
              <div class="mb-2 text-center text-2xl font-bold text-gray-700">{{$cps[0]->PlanName}}</div>
            </div>
            <div class="mt-auto">
              <p class="block rounded-lg bg-indigo-500 px-8 py-3 text-center text-sm font-semibold text-white outline-none ring-indigo-300 transition duration-100 md:text-base">{{number_format($cps[0]->Fee)}}円 / 月 </p>
            </div>
          </div>
        </div>
        <!-- 選択中のplan - end -->
        <!-- それ以外のplan - start -->
        @for ($i = 1; $i < $cps->count(); $i++)
        <!-- 選択中のplanがi==0に入っているため、1から始める -->
        <div class="flex flex-col overflow-hidden rounded-lg border sm:mt-8">
          <div class="h-2 bg-gray-500"></div>
          <div class="flex flex-1 flex-col p-4 pt-6 sm:p-6 sm:pt-8">
            <div class="flex sm:block sm:mb-12">
              <div class="mb-2 text-center text-2xl font-bold text-gray-700">{{$cps[$i]->CourseName}}</div>
              <div class="inline-block sm:hidden">・</div>
              <div class="mb-2 text-center text-2xl font-bold text-gray-700">{{$cps[$i]->PlanName}}</div>
            </div>
            <div class="mt-auto">
              <p class="block rounded-lg bg-gray-200 px-8 py-3 text-center text-sm font-semibold text-gray-500 outline-none ring-indigo-300 transition duration-100 md:text-base">{{number_format($cps[$i]->Fee)}}円 / 月 </p>
            </div>
          </div>
        </div>
        <!-- それ以外のplan - end -->
        @endfor
      </div>
      @endif
    </div>
  </div>
  <!-- 過去のコースプラン -->
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
      <p class="mb-2 text-center font-semibold text-gray-700 md:mb-3 lg:text-lg">過去のコース・プラン</p>
      <div class="mx-auto max-w-screen-md text-center text-gray-500 md:text-lg">
        <table class="table w-full text-sm text-left text-gray-600 min-w-full">
          <thead class="text-xs text-gray-700 bg-gray-100">
            <tr>
                <th class="p-4" >適用日</th>
                <th class="p-4" >コース</th>
                <th class="p-4" >プラン</th>
            </tr>
          </thead>
          <tbody>
            @for ($i = 1; $i < $cpHistories->count(); $i++)
            <tr>
                <td class="p-2">{{$cpHistories[$i]->ApplicationDate}}</td>
                <td class="p-2">{{$cpHistories[$i]->CourseName}}</td>
                <td class="p-2">{{$cpHistories[$i]->PlanName}}</td>
            </tr>
            @endfor
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>