<div class="container bg-white text-center">
    <div class="px-8 mx-auto">
    <select class="w-full sm:w-96 bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 py-2 mb-4 lg:mb-8" id="StudentCd" name="StudentCd"
        wire:model="selectedSCd">
        @foreach($students as $student)
            <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
        @endforeach
    </select>
    </div>
</div>
<div class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="mx-auto max-w-screen-xl px-4 md:px-8">
    <div class="mb-6 grid gap-6 sm:grid-cols-2 md:mb-8 lg:grid-cols-4 lg:gap-8">
      <!-- 選択中のplan - start -->
      <div class="flex flex-col overflow-hidden rounded-lg border-2 border-indigo-500">
        <div class="bg-indigo-500 py-2 text-center text-sm font-semibold uppercase tracking-widest text-white">現在のコースプラン</div>
        <div class="flex flex-1 flex-col p-4 pt-6 sm:p-6 sm:pt-8">
          <div class="flex sm:block sm:mb-12">
            <div class="mb-2 text-center text-2xl font-bold text-gray-700">｛コース名｝</div>
            <div class="inline-block sm:hidden">・</div>
            <div class="mb-2 text-center text-2xl font-bold text-gray-700">｛プラン名｝</div>
          </div>

          <div class="mt-auto">
            <p class="block rounded-lg bg-indigo-500 px-8 py-3 text-center text-sm font-semibold text-white outline-none ring-indigo-300 transition duration-100 md:text-base">{ 月謝 }円 / 月 </p>
          </div>
        </div>
      </div>
      <!-- 選択中のplan - end -->
      <!-- それ以外のplan - start -->
      @for ($i = 0; $i < 3; $i++)
      <div class="flex flex-col overflow-hidden rounded-lg border sm:mt-8">
        <div class="h-2 bg-gray-500"></div>
        <div class="flex flex-1 flex-col p-4 pt-6 sm:p-6 sm:pt-8">
          <div class="flex sm:block sm:mb-12">
            <div class="mb-2 text-center text-2xl font-bold text-gray-700">｛コース名｝</div>
            <div class="inline-block sm:hidden">・</div>
            <div class="mb-2 text-center text-2xl font-bold text-gray-700">｛プラン名｝</div>
          </div>
          <div class="mt-auto">
            <p class="block rounded-lg bg-gray-200 px-8 py-3 text-center text-sm font-semibold text-gray-500 outline-none ring-indigo-300 transition duration-100 md:text-base">{ 月謝 }円 / 月 </p>
          </div>
        </div>
      </div>
      <!-- それ以外のplan - end -->
      @endfor
    </div>
  </div>
</div>