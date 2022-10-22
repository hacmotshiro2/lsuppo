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
        <h1 class="text-black-800 text-4xl sm:text-5xl md:text-6xl font-bold mb-8 md:mb-12">いつもありがとうございます</h1>
        <p class="lg:w-4/5 text-gray-500 xl:text-lg leading-relaxed mb-8 md:mb-12">サポーターからのフィードバックメッセージをぜひご覧ください。</p>
      </div>
      <!-- content - end -->

      <!-- image - start -->
      <div class="xl:w-5/12 h-48 lg:h-auto bg-gray-100 overflow-hidden shadow-lg rounded-lg">
        <img src="https://images.unsplash.com/photo-1618004912476-29818d81ae2e?auto=format&q=75&fit=crop&w=1000" loading="lazy" alt="lsuppo mypage" class="w-full h-full object-cover object-center" />
      </div>
      <!-- image - end -->
    </section>
    <div>
      <a href="https://manabiail-steam.com/session-log/"><img src="/images/sessionlog-banner.png" loading="lazy" alt="セッションログ" class=" object-cover object-center shadow-lg mx-auto my-8 hover:scale-110 duration-300" /></a>
    </div>
  </div>
</div>
<!-- hero - end -->


@endsection