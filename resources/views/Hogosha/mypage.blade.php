@extends('layouts.lsuppo-base')

@section('title')
エルサポ 保護者ページ
@endsection

@section('content')

<!-- hero - start -->
<div class="bg-white pb-6 sm:pb-8 lg:pb-12">
  <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
    <section class="flex flex-col lg:flex-row justify-between gap-6 sm:gap-10 md:gap-16">
      <!-- content - start -->
      <div class="xl:w-5/12 flex flex-col justify-center sm:text-center lg:text-left lg:py-12 xl:py-24">
        <p class="text-indigo-500 md:text-lg xl:text-xl font-semibold mb-4 md:mb-6">{{$userName}}さん　こんにちは</p>
        <h2 class="text-indigo-500 text-4xl sm:text-5xl md:text-6xl font-bold mb-8 md:mb-12">いつもありがとうございます</h2>
        @can('hogosha-binded')
        @if($unreads > 0)
          <h3 class="text-gray-700 text-2xl sm:text-xl md:text-xl font-bold mb-8 md:mb-12"><a href="/fb/">{{$unreads}}件の未読フィードバックがあります</a></h3>
        @endif
        @if($unabsences > 0)
          <h3 class="text-gray-700 text-2xl sm:text-xl md:text-xl font-bold mb-8 md:mb-12"><a href="/absence/list/">{{$unabsences}}件の未振替があります</a></h3>
        @endif
        @endcan
        <p class="lg:w-4/5 text-gray-500 xl:text-lg leading-relaxed mb-8 md:mb-12">サポーターからのフィードバックメッセージをぜひご覧ください。</p>
      </div>
      <!-- content - end -->

      <!-- image - start -->
      <div class="xl:w-5/12 h-48 lg:h-auto bg-gray-100 overflow-hidden shadow-lg rounded-lg mt-4">
        <p class="text-lg ml-3">セッションカレンダー</p>
        <iframe class="w-full h-full" src="https://calendar.google.com/calendar/embed?height=600&wkst=7&bgcolor=%232f5597&ctz=Asia%2FTokyo&showTitle=0&showNav=1&showPrint=0&showTabs=0&showTz=0&mode=AGENDA&src=cTM2dG5zam9yMzhraWlwdDNvdWNoZDAwMGtAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&color=%23616161&color=%232f5597" style="border-width:0" frameborder="0" scrolling="no"></iframe>
        {{-- <img src="https://images.unsplash.com/photo-1618004912476-29818d81ae2e?auto=format&q=75&fit=crop&w=1000" loading="lazy" alt="lsuppo mypage" class="w-full h-full object-cover object-center" /> --}}
      </div>
      <!-- image - end -->
    </section>
    <div class="flex flex-wrap mx-auto my-8">
      <div class="mr-6">
        <a href="https://manabiail-steam.com/session-log/"><img src="/images/sessionlog-banner.png" loading="lazy" alt="セッションログ" class=" object-cover object-center shadow-lg mx-auto my-2 hover:scale-110 duration-300" /></a>
      </div>
      <div>
        <a href="https://manabiail-steam.com/lsuppo-manual/"><img src="/images/lsuppo-manual-banner.png" loading="lazy" alt="エルサポマニュアル" class=" object-cover object-center shadow-lg mx-auto my-2 hover:scale-110 duration-300" /></a>
      </div>
    </div>
  </div>
</div>
<!-- hero - end -->


@endsection