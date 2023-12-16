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
        <h2 class="text-indigo-500 text-3xl sm:text-5xl md:text-6xl font-bold mb-8 md:mb-12">いつもありがとうございます</h2>
        @can('hogosha-binded')
        @if($unreads > 0)
          <div class="overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min- pr-4 pt-2 pb-4 text-center sm:block sm:p-0">
                  <!--This is the background that overlays when the modal is active. It  has opacity, and that's why the background looks gray.-->
                  <!-----
                add this code to this very first div:
                fixed inset-0
              -->
              <div class="transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
              <span class="hidden sm:inline-block sm:align-middle sm:" aria-hidden="true">​</span>
              <!--Modal panel : This is where you put the pop-up's content, the div on top this coment is the wrapper -->
              <div class="inline-block w-full p-3 lg:p-6 overflow-hidden text-left align-bottom transition-all transform bg-gray-50 rounded-lg shadow-lg sm:shadow-xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <a href="/fb/">
                  <div class="my-6 sm:my-8 text-left flex">
                    <div class="w-11/12">
                      <h2 class="text-xl sm:text-2xl leading-none tracking-tighter text-gray-600"><span class="font-semibold">{{$unreads}}件</span>の未読フィードバックがあります</h2>
                    </div>
                    <div class="w-1/12">
                      <h2 class="text-xl sm:text-2xl font-semibold leading-none tracking-tighter text-gray-600">　<i class="fa-solid fa-chevron-right"></i></h2>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        @endif
        @if($unabsences > 0)
          <div class="overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min- pr-4 pt-2 pb-4 text-center sm:block sm:p-0">
                  <!--This is the background that overlays when the modal is active. It  has opacity, and that's why the background looks gray.-->
                  <!-----
                add this code to this very first div:
                fixed inset-0
              -->
              <div class="transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
              <span class="hidden sm:inline-block sm:align-middle sm:" aria-hidden="true">​</span>
              <!--Modal panel : This is where you put the pop-up's content, the div on top this coment is the wrapper -->
              <div class="inline-block w-full p-3 lg:p-6 overflow-hidden text-left align-bottom transition-all transform bg-gray-50 rounded-lg shadow-lg sm:shadow-xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <a href="/absence/list/">
                  <div class="my-6 sm:my-8 text-left flex">
                    <div class="w-11/12">
                      <h2 class="text-xl sm:text-2xl leading-none tracking-tighter text-gray-600"><span class="font-semibold">{{$unabsences}}件</span>の未振替があります</h2>
                    </div>
                    <div class="w-1/12">
                      <h2 class="text-xl sm:text-2xl font-semibold leading-none tracking-tighter text-gray-600">　<i class="fa-solid fa-chevron-right"></i></h2>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        @endif
        <!-- コース・プラン -->
          <div class="overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min- pr-4 pt-2 pb-4 text-center sm:block sm:p-0">
                  <!--This is the background that overlays when the modal is active. It  has opacity, and that's why the background looks gray.-->
                  <!-----
                add this code to this very first div:
                fixed inset-0
              -->
              <div class="transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
              <span class="hidden sm:inline-block sm:align-middle sm:" aria-hidden="true">​</span>
              <!--Modal panel : This is where you put the pop-up's content, the div on top this coment is the wrapper -->
              <div class="inline-block w-full p-3 lg:p-6 overflow-hidden text-left align-bottom transition-all transform bg-gray-50 rounded-lg shadow-lg sm:shadow-xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                @if(count($courseplans)>0)
                <a href="/cp/detail/">
                  <p class="text-base sm:text-xl">現在の受講コース・プラン</p>
                  <div class="my-6 sm:my-8 text-left flex">
                      <div class="w-11/12">
                        @foreach($courseplans as $cp)
                          <h4 class="text-base sm:text-xl font-semibold leading-none tracking-tighter text-gray-600">{{$cp->student->HyouziMei}}さん：</h4>
                          <h4 class="text-xl sm:text-2xl leading-none tracking-tighter text-gray-600">{{$cp->course->Value}}</h4>
                          <h4 class="text-xl sm:text-2xl leading-none tracking-tighter text-gray-600 mb-2">{{$cp->plan->Value}}</h4>
                        @endforeach
                      </div>
                      <div class="w-1/12">
                        <h2 class="text-xl sm:text-2xl font-semibold leading-none tracking-tighter text-gray-600">　<i class="fa-solid fa-chevron-right"></i></h2>
                      </div>
                  </div>
                </a>
                @else
                <div>
                  <p class="text-base sm:text-xl">現在の受講コース・プラン</p>
                  <div class="my-6 sm:my-8 text-left flex">
                      <div class="w-12/12">
                        <p>まだ登録がありません</P>
                      </div>
                  </div>
                </div>
                @endif
              </div>
          </div>
        @endcan
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