@extends('layouts.lsuppo-base')

@section('title')
エルサポ サポーターページ
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
        <p class="lg:w-4/5 text-gray-500 xl:text-lg leading-relaxed mb-8 md:mb-12">{{$userName}}さんの日頃からのご尽力に感謝いたします。保護者やお子様は{{$userName}}さんからのフィードバックを楽しみにしています。</p>
        @can('supporter-auth-9')
      <p><a href="sysad">super menu</a></p>
      @endcan
      </div>
      <!-- content - end -->

      <!-- image - start -->
      <div class="xl:w-5/12 h-48 lg:h-auto bg-gray-100 overflow-hidden shadow-lg rounded-lg">
        <img src="https://images.unsplash.com/photo-1618004912476-29818d81ae2e?auto=format&q=75&fit=crop&w=1000" loading="lazy" alt="Photo by Fakurian Design" class="w-full h-full object-cover object-center" />
      </div>
      <!-- image - end -->
    </section>
  </div>
</div>
<!-- hero - end -->


@endsection